<?php

Route::group(['module' => 'Author', 'middleware' => ['auth:api', 'verified'], 'namespace' => 'App\Modules\Author\Controllers'], function () {
    Route::get('api/author/{id}', 'AuthorControllerApi@showAuthor');
    Route::post('api/author/add', 'AuthorControllerApi@handleAddAuthor');
    Route::post('api/author/{id}/update', 'AuthorControllerApi@handleUpdateAuthor');
    Route::post('api/author/{id}/delete', 'AuthorControllerApi@handleDeleteAuthor');
});
