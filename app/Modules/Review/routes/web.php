<?php

Route::group(['module' => 'Review', 'middleware' => ['web','auth'], 'namespace' => 'App\Modules\Review\Controllers'], function() {

    Route::get('reviews', 'ReviewController@showReviews')->name('showReviews');

});
