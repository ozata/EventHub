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


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::apiResource('/events', 'Api\EventController');
    Route::apiResource('/games', 'Api\GameController');
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
