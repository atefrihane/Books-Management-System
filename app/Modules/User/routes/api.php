<?php

Route::group(['module' => 'User', 'middleware' => ['api'], 'namespace' => 'App\Modules\User\Controllers'], function () {

    Route::post('/api/login', 'UserControllerApi@handleLogin');
    Route::post('/api/register', 'UserControllerApi@handleRegister');
    Route::post('/api/register/admin', 'UserControllerApi@handleRegisterBackoffice');
    Route::get('api/home', 'UserControllerApi@showUserHomeDetails');
});

Route::group(['module' => 'User', 'middleware' => ['auth:api'], 'namespace' => 'App\Modules\User\Controllers'], function () {

    Route::get('/api/user/{id}','UserControllerApi@showUserDetails');
    Route::post('/api/user/{id}/update', 'UserControllerApi@handleUpdateProfile');
    Route::post('/api/admin/user/{id}/update', 'UserControllerApi@handleUpdateAdminProfile');
    Route::post('/api/user/{id}/delete', 'UserControllerApi@handleDeleteUser');
    Route::get('/api/user/{id}/block', 'UserControllerApi@handleBlockUser');
    Route::get('/api/user/{id}/unblock', 'UserControllerApi@handleUnblockUser');
  
});


