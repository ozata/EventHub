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

//Route::apiResource('/games','Api\GameController');
// Böyle yazılabilir ama API kaynağındaki tüm standart route'lar için üsttekini yazmak gerekiyor.
// Route::get('/events', 'Api\EventController@index');
// Route::get('/events/{id}', 'Api\EventController@show');
// Route::delete('/events/{id}', 'Api\EventController@destroy');


// Tek resource'u wrappingsiz yapmak için
//EventResource::withoutWrapping();

//return EventResource::collection(App\Event::paginate(10));
//return EventResource::collection(App\Event::all());
//return new EventResource(App\Event::find(1));
//return response()->json(['events' => App\Event::all()], 200);
//return App\Event::all();
