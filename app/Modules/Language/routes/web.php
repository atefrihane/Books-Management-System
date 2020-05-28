<?php

Route::group(['module' => 'Language', 'middleware' => ['web'], 'namespace' => 'App\Modules\Language\Controllers'], function() {

    Route::resource('Language', 'LanguageController');

});
