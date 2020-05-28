<?php

Route::group(['module' => 'Article', 'middleware' => ['api'], 'namespace' => 'App\Modules\Article\Controllers'], function() {
    Route::get('api/articles', 'ArticleControllerApi@showFilterArticles');
    Route::get('api/articles/search', 'ArticleControllerApi@handleSearchArticles');
    Route::get('api/article/{id}', 'ArticleControllerApi@showArticle');

});


Route::group(['module' => 'Article', 'middleware' => ['auth:api'], 'namespace' => 'App\Modules\Article\Controllers'], function() {

    Route::post('api/article/save', 'ArticleControllerApi@handleSaveArticle');
    Route::post('api/article/{id}/update', 'ArticleControllerApi@handleUpdateArticle');
    Route::post('api/article/{id}/delete', 'ArticleControllerApi@handleDeleteArticle');
});
