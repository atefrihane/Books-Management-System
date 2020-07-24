<?php

Route::group(['module' => 'Collection', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Collection\Controllers'], function () {

    Route::get('/collections', 'CollectionController@showCollections')->name('showCollections');
    Route::get('/collection/{id}', 'CollectionController@showCollection')->name('showCollection');
    Route::get('/collections/add', 'CollectionController@showAddCollection')->name('showAddCollection');
    Route::get('/collection/{id}/update', 'CollectionController@showUpdateCollection')->name('showUpdateCollection');
    Route::post('/collection/{id}/update', 'CollectionController@showUpdateCollection')->name('showUpdateCollection');
});
