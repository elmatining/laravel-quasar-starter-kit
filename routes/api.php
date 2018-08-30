<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'auth'], function() {
    Route::get('login/social/{social}', 'Web\AuthController@loginSocial');


    Route::group(['middleware' => 'auth:api'], function ($route) {
        $route->get('/user', 'Web\AuthController@getAuthenticated');
    });
});


