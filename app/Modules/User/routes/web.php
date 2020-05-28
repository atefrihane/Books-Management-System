<?php

Route::group(['module' => 'User', 'middleware' => ['web'], 'namespace' => 'App\Modules\User\Controllers'], function() {

    Route::post('/login','UserController@handleLogin')->name('handleLogin');
    Route::get('/logout','UserController@handleLogout')->name('handleLogout');
});

Route::group(['module' => 'User', 'middleware' => ['web','auth'], 'namespace' => 'App\Modules\User\Controllers'], function() {

  
    Route::get('/users','UserController@showUsers')->name('showUsers');
    Route::get('/users/add','UserController@showAddUser')->name('showAddUser');
    Route::get('/user/{id}','UserController@showUser')->name('showUser');
    Route::get('/user/{id}/update','UserController@showUpdateUser')->name('showUpdateUser');
});
