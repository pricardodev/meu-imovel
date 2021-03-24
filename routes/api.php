<?php

Route::prefix('v1')->namespace('Api')->group(function(){

    Route::post('login', 'Auth\LoginJwtController@login')->name('login');
    Route::get('logout', 'Auth\LoginJwtController@logout')->name('logout');
    Route::get('refresh', 'Auth\LoginJwtController@refresh')->name('refresh');

    Route::resource('real-states', 'RealStateController')->middleware('jwt.auth');
    Route::resource('users', 'UserController')->middleware('jwt.auth');;

    Route::get('categories/{id}/real-states', 'CategoryController@realState')->middleware('jwt.auth');;
    Route::resource('categories', 'CategoryController')->middleware('jwt.auth');;

    Route::put('photos/set-thumb/{photoId}/{realStateId}', 'RealStatePhotoController@setThumb')->middleware('jwt.auth');;
    Route::delete('photos/{id}', 'RealStatePhotoController@remove')->middleware('jwt.auth');;

});

// Posso criar um route group
Route::group(['middleware' => ['jwt.auth']], function(){

});
