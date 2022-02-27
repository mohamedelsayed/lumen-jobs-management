<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group(
    ['prefix' => 'api/v1', 'middleware' => []],
    function ($router) {
        $router->post('login', 'AuthController@authenticate');
    }
);
$router->group(['prefix' => 'api/v1', 'middleware' => ['auth']], function ($router) {
    $router->get('jobs', 'JobsController@index');
    $router->get('jobs/{id}', 'JobsController@show');
    $router->post('jobs', 'JobsController@store');
    $router->put('jobs/{id}', 'JobsController@update');
    $router->delete('jobs/{id}', 'JobsController@delete');
});
