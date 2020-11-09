<?php

Route::prefix('v1')->namespace('Api')->group(function(){
    Route::resource('real-states', 'RealStateController');
    Route::resource('users', 'UserController');

    Route::get('categories/{id}/real-states', 'CategoryController@realState');
    Route::resource('categories', 'CategoryController');

    Route::put('photos/set-thumb/{photoId}/{realStateId}', 'RealStatePhotoController@setThumb');
    Route::delete('photos/{id}', 'RealStatePhotoController@remove');

});
