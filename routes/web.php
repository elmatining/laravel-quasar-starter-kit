<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/auth/social/{social}', 'Web\AuthController@redirectToSocial');
Route::get('/auth/{social}/callback', 'Web\AuthController@handleSocialCallback');

// Redirect all to the front-end router
Route::get('/{pattern?}', function() {
    return view('app');
})->where('pattern', '[\/\w\.-]*');
