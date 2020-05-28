<?php

Route::group(['module' => 'Order', 'middleware' => ['web','auth'], 'namespace' => 'App\Modules\Order\Controllers'], function() {

    Route::get('orders', 'OrderController@showOrders')->name('showOrders');
    Route::get('order/{id}', 'OrderController@showOrder')->name('showOrder');
});
