<?php

Route::group(['module' => 'Language', 'middleware' => ['api'], 'namespace' => 'App\Modules\Language\Controllers'], function() {

    Route::resource('Language', 'LanguageController');

});
