<?php

use Illuminate\Http\Request;
use App\Http\Resources\EventResource;
use App\Http\Resources\GameResource;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});


Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::apiResource('/events', 'Api\EventController');
    Route::apiResource('/games', 'Api\GameController');
});

Route::group(['middleware' => 'auth:api'], function(){
    // Users
    Route::get('users', 'UserController@index')->middleware('isAdmin');
    Route::get('users/{id}', 'UserController@show')->middleware('isAdminOrSelf');
});


Route::post('events/join/{id}', 'Api\EventController@join')->name('events.join');
Route::post('events/getparticipants', 'Api\EventController@getParticipants')->name('events.getparticipants');