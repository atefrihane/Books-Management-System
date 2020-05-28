<?php

Route::group(['module' => 'Release', 'middleware' => ['api'], 'namespace' => 'App\Modules\Release\Controllers'], function () {
    Route::get('api/release/{id}', 'ReleaseControllerApi@showRelease');
    Route::post('api/journal/{id}/release/add', 'ReleaseControllerApi@handleSaveRelease');
    Route::post('api/release/{id}/delete', 'ReleaseControllerApi@handleDeleteRelease');
    Route::post('api/release/{id}/update', 'ReleaseControllerApi@handleUpdateRelease');
});
