<?php

namespace Tests\Jobs;

use App\Models\Job;
use App\Models\User;
use TestCase;
use Faker\Factory;

class StoreTest extends TestCase
{
    /**
     * Package Store Test
     *
     * @return void
     */

    public function testUserCabStoreSuccess()
    {
        $user = User::factory()->create(['is_manager' => false]);
        $faker = Factory::create();
        $data = [
            'title' =>  $faker->title(),
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
        $item = json_decode($response->response->getContent());
        $item_id = $item->job->id;
        Job::find($item_id)->delete();
        $user->delete();
    }

    public function testUserCabStoreFail()
    {
        $user = User::factory()->create(['is_manager' => false]);
        $faker = Factory::create();
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
     }
}
