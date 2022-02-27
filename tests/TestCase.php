<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    public function getApiUrl()
    {
        return config("app.url");
    }

    protected function loginAsUser($user = null)
    {
        if ($user) {
            $apiToken = $user->api_token;
            if ($apiToken) {
                $headers = [
                    'Authorization' => 'Bearer ' . $apiToken,
                ];
                return $headers;
            }
        }
        return [];
    }
}
