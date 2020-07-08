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

$router->group(['middleware' => 'auth'], function () use ($router) {

  $router->get('items/', "ItemController@getItems");

  $router->get('item/{id}', "ItemController@getItem");

  $router->post('item/','ItemController@addItem');

  $router->put('item/{id}', 'ItemController@updateItem');

  $router->delete('item/{id}', 'ItemController@deleteItem');

  $router->get('logout/','UserController@logout');

});

$router->post('register/','UserController@register');

$router->get('login/','UserController@login');
