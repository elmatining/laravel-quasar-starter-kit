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
Route::group(['prefix' => 'auth', 'namespace' => 'Web'], function () {
    Route::get('login/social/{social}', 'AuthController@loginSocial');


    Route::group(['middleware' => 'auth:api'], function () {
        Route::get(
            '/user',
            [
                'uses' => AuthController::class . '@getAuthenticated',
                'as'   => 'auth.user'
            ]
        );
    });
});

Route::group(['middleware' => 'auth:api', 'namespace' => 'Administration'], function () {
    Route::apiResource('users', 'UserController')->except(['create', 'store']);

    Route::get(
        'users/{user}/relationships/profile',
        [
            'uses' => UserRelationshipController::class . '@profile',
            'as'   => 'users.relationships.profile'
        ]
    );

    Route::get(
        'users/{user}/profile',
        [
            'uses' => UserRelationshipController::class . '@profile',
            'as'   => 'users.profile'
        ]
    );

    Route::apiResource('roles', 'RoleController');
    Route::apiResource('permissions', 'PermissionController')->only(['index']);
});
