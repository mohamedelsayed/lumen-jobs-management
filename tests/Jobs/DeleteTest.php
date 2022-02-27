<?php

namespace Tests\Jobs;

use App\Models\Job;
use App\Models\User;
use TestCase;

class DeleteTest extends TestCase
{
    /**
     * Job Delete Test
     *
     * @return void
     */

    public function testUserCanDeleteSuccess()
    {
        $user = User::factory()->create(['is_manager' => false]);
        $job = Job::factory()->create(['user_id' => $user->id]);
        $data = [];
        $apiUrl = $this->getApiUrl();
        $headers = $this->loginAsUser($user);
        $response = $this->json('DELETE',  $apiUrl . '/api/v1/jobs/' . $job->id, $data, $headers);
        // print_r(json_decode($response->response->getContent()));
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            "status",
        ]);
        $response->seeJson([
            "status" => 'success',
        ]);
        $user->delete();
    }

    public function testUserCanDeleteFail()
    {
        $user = User::factory()->create(['is_manager' => false]);
        $job = Job::factory()->create(['user_id' => $user->id]);
        $data = [];
        $apiUrl = $this->getApiUrl();
        $headers = $this->loginAsUser($user);
        $response = $this->json('DELETE',  $apiUrl . '/api/v1/jobs/' . $job->id . 'abc', $data, $headers);
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
