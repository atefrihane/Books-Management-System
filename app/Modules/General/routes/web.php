<?php

Route::group(['module' => 'General', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\General\Controllers'], function () {

    Route::get('/', 'GeneralController@showHome')->name('showHome');
    Route::get('/notfound', 'GeneralController@showNotFoundPage')->name('showNotFoundPage');

});

Route::group(['module' => 'General', 'middleware' => [ 'web','guest'], 'namespace' => 'App\Modules\General\Controllers'], function () {

    Route::get('/login', 'GeneralController@showLogin')->name('showLogin');
});
