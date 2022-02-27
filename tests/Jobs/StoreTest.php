<?php

namespace Tests\Jobs;

use App\Models\Job;
use App\Models\User;
use TestCase;
use Faker\Factory;

class StoreTest extends TestCase
{
    /**
     * Job Store Test
     *
     * @return void
     */

    public function testUserCanStoreSuccess()
    {
        $user = User::factory()->create(['is_manager' => false]);
        $faker = Factory::create();
        $title=$faker->title();
        $data = [
            'title' =>  $title,
            'description' => $faker->text(),
        ];
        $apiUrl = $this->getApiUrl();
        $headers = $this->loginAsUser($user);
        $response = $this->json('POST',  $apiUrl . '/api/v1/jobs', $data, $headers);
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
        $item = json_decode($response->response->getContent());
        $item_id = $item->job->id;
        Job::find($item_id)->delete();
        $user->delete();
    }

    public function testUserCanStoreFail()
    {
        $user = User::factory()->create(['is_manager' => false]);
        $data = [
        ];
        $apiUrl = $this->getApiUrl();
        $headers = $this->loginAsUser($user);
        $response = $this->json('POST',  $apiUrl . '/api/v1/jobs', $data, $headers);
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
     }
}
