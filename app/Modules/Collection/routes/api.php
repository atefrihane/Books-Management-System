<?php

Route::group(['module' => 'Collection', 'middleware' => ['api','auth:api'], 'namespace' => 'App\Modules\Collection\Controllers'], function() {
    Route::post('/api/collection/{id}/delete', 'CollectionControllerApi@handleDeleteCollection');
    Route::post('/api/collections/add', 'CollectionControllerApi@handleAddCollection');
    Route::post('/api/collection/{id}/update', 'CollectionControllerApi@handleUpdateCollection');
});
