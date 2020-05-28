<?php

Route::group(['module' => 'Order', 'middleware' => ['auth:api','verified'], 'namespace' => 'App\Modules\Order\Controllers'], function() {
    Route::get('api/orders/user/{id}','OrderControllerApi@showUserOrders');
    Route::post('api/order/add', 'OrderControllerApi@handleStoreOrder');
    Route::post('api/order/{id}/status', 'OrderControllerApi@handleUpdateStatus');
});
