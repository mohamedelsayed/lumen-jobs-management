<?php

namespace Tests\Jobs;

use App\Models\Job;
use App\Models\User;
use TestCase;
use Faker\Factory;

class UpdateTest extends TestCase
{
    /**
     * Job Update Test
     *
     * @return void
     */

    public function testUserCanUpdateSuccess()
    {
        $user = User::factory()->create(['is_manager' => false]);
        $job = Job::factory()->create(['user_id' => $user->id]);
        $faker = Factory::create();
        $title = $faker->title();
        $data = [
            'title' =>  $title,
            'description' => $faker->text(),
        ];
        $apiUrl = $this->getApiUrl();
        $headers = $this->loginAsUser($user);
        $response = $this->json('PUT',  $apiUrl . '/api/v1/jobs/' . $job->id, $data, $headers);
        // print_r(json_decode($response->response->getContent()));
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            "status",
            "job"
        ]);
        $response->seeJson([
            "status" => 'success',
        ]);
        $response->seeJson([$title]);
        $user->delete();
        $job->delete();
    }

    public function testUserCanUpdateFail()
    {
        $user = User::factory()->create(['is_manager' => false]);
        $job = Job::factory()->create(['user_id' => $user->id]);
        $data = [
        ];
        $apiUrl = $this->getApiUrl();
        $headers = $this->loginAsUser($user);
        $response = $this->json('PUT',  $apiUrl . '/api/v1/jobs/'. $job->id, $data, $headers);
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
