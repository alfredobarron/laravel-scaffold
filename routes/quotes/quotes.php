<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Quotes'], function() {
        // views
        Route::group(['prefix' => 'quotes'], function() {
            Route::view('/', 'quotes.index')->middleware('permission:read-quotes');
            Route::view('/create', 'quotes.create')->middleware('permission:create-quotes');
            Route::view('/{quote}/edit', 'quotes.edit')->middleware('permission:update-quotes');
        });

        // api
        Route::group(['prefix' => 'api/quotes'], function() {
            Route::post('/filter', 'QuotesController@filter')->middleware('permission:read-quotes');
            Route::get('/byCreator', 'QuotesController@byCreator')->middleware('permission:read-quotes');
            Route::get('/all', 'Quotes@all')->middleware('permission:read-quotes');

            Route::get('/{quote}', 'QuotesController@show')->middleware('permission:read-quotes');
            Route::post('/store', 'QuotesController@store')->middleware('permission:create-quotes');
            Route::put('/update/{quote}', 'QuotesController@update')->middleware('permission:update-quotes');
            Route::delete('/{quote}', 'QuotesController@destroy')->middleware('permission:delete-quotes');
        });
    });
});
