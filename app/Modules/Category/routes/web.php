<?php

Route::group(['module' => 'Category', 'middleware' => ['web','auth'], 'namespace' => 'App\Modules\Category\Controllers'], function() {

    Route::get('categories', 'CategoryController@showCategories')->name('showCategories');
    Route::view('categories/add', 'Category::showAddCategory')->name('showAddCategory');
    Route::get('category/{id}/update', 'CategoryController@showUpdateCategory')->name('showUpdateCategory');

});
