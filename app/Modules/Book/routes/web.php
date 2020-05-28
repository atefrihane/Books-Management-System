<?php

Route::group(['module' => 'Book', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Book\Controllers'], function () {

    Route::get('/books', 'BookController@showBooks')->name('showBooks');
    Route::get('/book/add', 'BookController@showAddBook')->name('showAddBook');
    Route::get('/book/{id}', 'BookController@showBook')->name('showBook');
    Route::get('/book/{id}/update', 'BookController@showUpdateBook')->name('showUpdateBook');
});
