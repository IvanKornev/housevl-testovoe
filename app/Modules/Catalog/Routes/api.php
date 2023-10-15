<?php

use App\Modules\Catalog\Http\Controllers\TreeController;
use App\Modules\Catalog\Http\Controllers\ProductController;
use App\Modules\Catalog\Http\Controllers\ProductCharacteristicController;

$productsGroupCallback = function () {
    Route::get('/', [ProductController::class, 'getAll']);
    Route::get('/{slug}', [ProductController::class, 'get']);
    Route::patch('/characteristics/{id}', [
        ProductCharacteristicController::class, 'update',
    ])->where('id', '[0-9]+');
};
Route::prefix('products')->group($productsGroupCallback);
Route::get('/catalog/tree', [TreeController::class, 'get']);
