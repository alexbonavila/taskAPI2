<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/auth/login', function () {
    return 'No tens acces a la API';
});
Route::group(['middleware' => 'throttle:5,10'], function () {
    Route::get('task/{id}/tag', 'TagController@index');
    Route::resource('task', 'TaskController');
    Route::resource('tag', 'TagController');
});