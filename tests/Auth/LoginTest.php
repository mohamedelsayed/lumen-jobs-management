<?php

namespace Tests\Auth;

use App\Models\User;
use TestCase;

class LoginTest extends TestCase
{
    public function testUserCanLoginSuccess()
    {
        $password = '123456a!A';
        $user = User::factory()->create([
            'password' => $password,
        ]);
        $data = [
            'email' => $user->email,
            'password' => $password,
        ];
        $apiUrl = $this->getApiUrl();
        $response = $this->json('POST',  $apiUrl . '/api/v1/login', $data);
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            "status",
            "api_token"
        ]);
        $response->seeJson([
            "status" => 'success',
        ]);
        $user->delete();
    }
    public function testUserCanLoginFail()
    {
        $password = '123456a!A';
        $user = User::factory()->create([
            'password' => $password,
        ]);
        $data = [
            'email' => $user->email."aaa",
            'password' => $password,
        ];
        $apiUrl = $this->getApiUrl();
        $response = $this->json('POST',  $apiUrl . '/api/v1/login', $data);
        $response->assertResponseStatus(401);      
        $response->seeJson(["status" => 'fail',]);
        $user->delete();
    }
}
