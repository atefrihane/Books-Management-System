<?php


Route::group(['module' => 'Product', 'middleware' => ['api'], 'namespace' => 'App\Modules\Product\Controllers'], function() {
    Route::get('api/products/search','ProductControllerApi@handleSearchProducts');
 
});
Route::group(['module' => 'Product', 'middleware' => ['auth:api','verified'], 'namespace' => 'App\Modules\Product\Controllers'], function() {
    Route::post('api/products/search','ProductControllerApi@handleSearchProducts');
    Route::post('api/products/save', 'ProductControllerApi@saveProduct');
    Route::post('api/products/download/save', 'ProductControllerApi@saveDownload');
});
