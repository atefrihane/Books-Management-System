<?php

Route::group(['module' => 'Category', 'middleware' => ['auth:api'], 'namespace' => 'App\Modules\Category\Controllers'], function() {
    Route::get('api/categories', 'CategoryControllerApi@showCategories');
    Route::post('api/category/add', 'CategoryControllerApi@handleAddCategory');
    Route::post('api/category/{id}/update', 'CategoryControllerApi@handleUpdateCategory');
    Route::post('api/category/{id}/delete', 'CategoryControllerApi@handleDeleteCategory');

});
