<?php

namespace Tests\Jobs;

use App\Models\Job;
use App\Models\User;
use TestCase;

class IndexTest extends TestCase
{
    public function testCanRegularUserIndex()
    {
        $user = User::factory()->create(['is_manager' => false]);
        $job = Job::factory()->create(['user_id' => $user->id]);
        $data = [];
        $apiUrl = $this->getApiUrl();
        $headers = $this->loginAsUser($user);
        $response = $this->json('GET',  $apiUrl . '/api/v1/jobs', $data, $headers);
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            "status",
            "jobs"
        ]);
        $response->seeJson([
            "status" => 'success',
        ]);
        $response->seeJson([$job->title]);
        // print_r(json_decode($response->response->getContent()));
        $user->delete();
        $job->delete();
    }
    public function testCanManagerUserIndex()
    {
        $user1 = User::factory()->create(['is_manager' => True]);
        $user2 = User::factory()->create(['is_manager' => false]);
        $job = Job::factory()->create(['user_id' => $user2->id]);
        $data = [];
        $apiUrl = $this->getApiUrl();
        $headers = $this->loginAsUser($user1);
        $response = $this->json('GET',  $apiUrl . '/api/v1/jobs', $data, $headers);
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            "status",
            "jobs"
        ]);
        $response->seeJson([
            "status" => 'success',
        ]);
        //assert that manager "$user1" can see job of other user "$user2"
        $response->seeJson([$job->title]);
        $user1->delete();
        $user2->delete();
        $job->delete();
    }
    public function testCanUserIndexFail()
    {
        $data = [];
        $apiUrl = $this->getApiUrl();
        $response = $this->json('GET',  $apiUrl . '/api/v1/jobs', $data);
        $response->assertResponseStatus(401);
        $response->seeJsonStructure([
            "status",
            "error"
        ]);
        $response->seeJson(["status" => 'fail',]);
    }
}
