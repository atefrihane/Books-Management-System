<?php

Route::group(['module' => 'Release', 'middleware' => ['web','auth'], 'namespace' => 'App\Modules\Release\Controllers'], function() {
    Route::get('release/{id}', 'ReleaseController@showRelease')->name('showRelease');
    Route::get('journal/{id}/release/add', 'ReleaseController@showAddRelease')->name('showAddRelease');
    Route::get('release/{id}/update', 'ReleaseController@showUpdateRelease')->name('showUpdateRelease');
});
