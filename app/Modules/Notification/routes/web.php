<?php

Route::group(['module' => 'Notification', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Notification\Controllers'], function () {

    Route::view('/notification/send', 'Notification::showSendNotification')->name('showSendNotification');

});
