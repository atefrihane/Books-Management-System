<?php

Route::group(['module' => 'Collection', 'middleware' => ['web','auth'], 'namespace' => 'App\Modules\Collection\Controllers'], function () {

    Route::get('/collections', 'CollectionController@showCollections')->name('showCollections');
    Route::post('/collections/add', 'CollectionController@showAddCollection')->name('showAddCollection');
    Route::post('/collections/{id}/update', 'CollectionController@showUpdateCollection')->name('showUpdateCollection');
});
