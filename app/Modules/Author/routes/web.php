<?php

Route::group(['module' => 'Author', 'middleware' => ['web','auth'], 'namespace' => 'App\Modules\Author\Controllers'], function() {

    Route::get('authors', 'AuthorController@showAuthors')->name('showAuthors');
    Route::get('author/add', 'AuthorController@showAddAuthor')->name('showAddAuthor');
    Route::get('/author/{id}', 'AuthorController@showAuthor')->name('showAuthor');
     Route::get('/author/{id}/update', 'AuthorController@showUpdateAuthor')->name('showUpdateAuthor');
});
