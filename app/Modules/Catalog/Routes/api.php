<?php

use App\Modules\Catalog\Http\Controllers\TreeController;
use App\Modules\Catalog\Http\Controllers\ProductController;
use App\Modules\Catalog\Http\Controllers\ProductCharacteristicController;

Route::get('/catalog/tree', [TreeController::class, 'get']);
Route::get('/products/{slug}', [ProductController::class, 'get']);
Route::patch('/products/characteristics/{id}', [
    ProductCharacteristicController::class, 'update',
]);
