<?php

Route::group(['module' => 'Support', 'middleware' => ['web','auth'], 'namespace' => 'App\Modules\Support\Controllers'], function() {

    Route::get('supports', 'SupportController@showSupports')->name('showSupports');
    Route::get('support/{id}', 'SupportController@showSupport')->name('showSupport');
});
