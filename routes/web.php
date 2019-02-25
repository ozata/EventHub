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



//Route::get('/', function () {
//    return view('index');
//});

// Route to handle page reload in Vue except for api routes
Route::get('/{any?}', function (){
    return view('index');
})->where('any', '^(?!api\/)[\/\w\.-]*');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

