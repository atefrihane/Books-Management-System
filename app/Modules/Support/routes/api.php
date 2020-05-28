<?php

Route::group(['module' => 'Support', 'middleware' => ['auth:api','verified'], 'namespace' => 'App\Modules\Support\Controllers'], function() {

    Route::post('api/support/add', 'SupportControllerApi@handleAddSupport');
    Route::post('api/support/{id}/update', 'SupportControllerApi@handleUpdateSupport');
    Route::post('api/supports/{id}/delete', 'SupportControllerApi@handleDeleteSupport');
});
