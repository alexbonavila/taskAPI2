<?php
Route::group(['middleware' => ['auth']], function () {
    Route::get('task/{id}/tag', 'TagController@index');
    Route::resource('task', 'TaskController');
    Route::resource('tag', 'TagController');
});