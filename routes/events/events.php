<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Events'], function() {
        // views
        Route::group(['prefix' => 'events'], function() {
            Route::view('/', 'events.index')->middleware('permission:read-events');
            // Route::view('/create', 'events.create')->middleware('permission:create-events');
            // Route::view('/{user}/edit', 'events.edit')->middleware('permission:update-events');
        });

        // api
        Route::group(['prefix' => 'api/events'], function() {
            //Route::post('/filter', 'EventController@filter')->middleware('permission:read-events');
            Route::get('/all', 'EventController@all')->middleware('permission:read-events');
            Route::post('/byUser', 'EventController@byUser')->middleware('permission:read-events');

            //Route::get('/{user}', 'EventController@show')->middleware('permission:read-events');
            Route::post('/store', 'EventController@store')->middleware('permission:create-events');
            Route::put('/update/{user}', 'EventController@update')->middleware('permission:update-events');
            Route::delete('/{user}', 'EventController@destroy')->middleware('permission:delete-events');
        });
    });
});
