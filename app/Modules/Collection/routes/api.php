<?php

Route::group(['module' => 'Collection', 'middleware' => ['api'], 'namespace' => 'App\Modules\Collection\Controllers'], function() {

    Route::resource('Collection', 'CollectionController');

});
