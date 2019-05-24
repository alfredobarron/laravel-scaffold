<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'QuotesCompanies'], function() {
        // views
        Route::group(['prefix' => 'quotesCompanies'], function() {
            Route::view('/', 'quotesCompanies.index')->middleware('permission:read-quotescompanies');
            Route::view('/create', 'quotesCompanies.create')->middleware('permission:create-quotescompanies');
            Route::view('/{quote}/edit', 'quotesCompanies.edit')->middleware('permission:update-quotescompanies');
        });

        // api
        Route::group(['prefix' => 'api/quotesCompanies'], function() {
            Route::post('/filter', 'QuotesCompaniesController@filter')->middleware('permission:read-quotescompanies');
            Route::get('/byCreator', 'QuotesCompaniesController@byCreator')->middleware('permission:read-quotescompanies');
            Route::get('/all', 'QuotesCompaniesController@all')->middleware('permission:read-quotescompanies');

            Route::get('/{quote}', 'QuotesCompaniesController@show')->middleware('permission:read-quotescompanies');
            Route::post('/store', 'QuotesCompaniesController@store')->middleware('permission:create-quotescompanies');
            Route::put('/update/{quote}', 'QuotesCompaniesController@update')->middleware('permission:update-quotescompanies');
            Route::delete('/{quote}', 'QuotesCompaniesController@destroy')->middleware('permission:delete-quotescompanies');
        });
    });
});
