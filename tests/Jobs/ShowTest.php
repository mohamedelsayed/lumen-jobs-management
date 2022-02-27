<?php

namespace Tests\Jobs;

use App\Models\Job;
use App\Models\User;
use TestCase;

class ShowTest extends TestCase
{
    /**
     * Job Show Test
     *
     * @return void
     */

    public function testRegularUserCanShowSuccess()
    {
        $user = User::factory()->create(['is_manager' => false]);
        $job = Job::factory()->create(['user_id' => $user->id]);
        $data = [];
        $apiUrl = $this->getApiUrl();
        $headers = $this->loginAsUser($user);
        $response = $this->json('GET',  $apiUrl . '/api/v1/jobs/' . $job->id, $data, $headers);
        // print_r(json_decode($response->response->getContent()));
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            "status",
            "job"
        ]);
        $response->seeJson([
            "status" => 'success',
        ]);
        $response->seeJson([$job->title]);
        $user->delete();
        $job->delete();
    }
    public function testManagerUserCanShowSuccess()
    {
        $user1 = User::factory()->create(['is_manager' => true]);
        $user2 = User::factory()->create(['is_manager' => false]);

        $job = Job::factory()->create(['user_id' => $user2->id]);
        $data = [];
        $apiUrl = $this->getApiUrl();
        $headers = $this->loginAsUser($user1);
        $response = $this->json('GET',  $apiUrl . '/api/v1/jobs/' . $job->id, $data, $headers);
        // print_r(json_decode($response->response->getContent()));
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            "status",
            "job"
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

    public function testUserCanShowFail()
    {
        $user = User::factory()->create(['is_manager' => false]);
        $job = Job::factory()->create(['user_id' => $user->id]);
        $data = [
        ];
        $apiUrl = $this->getApiUrl();
        $headers = $this->loginAsUser($user);
        $response = $this->json('GET',  $apiUrl . '/api/v1/jobs/'. $job->id.'abc', $data, $headers);
        // print_r(json_decode($response->response->getContent()));
        $response->assertResponseStatus(400);
        $response->seeJsonStructure([
            "status",
            "errors"
        ]);
        $response->seeJson([
            "status" => 'fail',
        ]);
        $user->delete();
        $job->delete();
     }
}
