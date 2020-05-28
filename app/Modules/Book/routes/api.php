<?php


Route::group(['module' => 'Book', 'middleware' => ['api'], 'namespace' => 'App\Modules\Book\Controllers'], function() {
    Route::get('/api/books/search','BookControllerApi@handleSearchBooks');
    Route::get('/api/books','BookControllerApi@showFilterBooks');
    Route::get('/api/book/{id}','BookControllerApi@showBook');
    Route::get('/api/books/filter','BookControllerApi@showFilterBooks');
    Route::get('api/books/category/{name}', 'BookControllerApi@handleFilterBooksByCategory'); // show books of a specfic category
 
    
});


Route::group(['module' => 'Book', 'middleware' => ['auth:api'], 'namespace' => 'App\Modules\Book\Controllers'], function() {

    Route::post('api/book/save', 'BookControllerApi@handleSaveBook'); //add book
    Route::post('api/book/{id}/update', 'BookControllerApi@handleUpdateBook'); // update book
    Route::post('api/book/{id}/delete', 'BookControllerApi@handleDeleteBook'); // delete book
    
});


