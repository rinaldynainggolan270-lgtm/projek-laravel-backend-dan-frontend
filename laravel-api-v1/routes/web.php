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

// Gunakan prefix 'api' dan di dalam group cukup tulis '/sports' tanpa prefix lagi
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/sports', 'SportController@index');
    $router->post('/sports', 'SportController@store');
    $router->get('/sports/{id}', 'SportController@show');
    $router->put('/sports/{id}', 'SportController@update');
    $router->delete('/sports/{id}', 'SportController@destroy');
});