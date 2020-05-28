<?php

Route::group(['module' => 'Review', 'middleware' => ['auth:api','verified'], 'namespace' => 'App\Modules\Review\Controllers'], function() {
    Route::get('api/reviews/user/{id}', 'ReviewControllerApi@showUserReviews');
    Route::post('api/review/add', 'ReviewControllerApi@handleStoreReview');
    Route::post('api/review/{id}/status', 'ReviewControllerApi@handleUpdateStatus');

});
