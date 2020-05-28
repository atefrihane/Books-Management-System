<?php

Route::group(['module' => 'Article', 'middleware' => ['web','auth'], 'namespace' => 'App\Modules\Article\Controllers'], function() {

    Route::get('/articles', 'ArticleController@showArticles')->name('showArticles');
    Route::get('/articles/add', 'ArticleController@showAddArticle')->name('showAddArticle');
    Route::get('/article/{id}', 'ArticleController@showArticle')->name('showArticle');
    Route::get('/article/{id}/update', 'ArticleController@showUpdateArticle')->name('showUpdateArticle');
});
