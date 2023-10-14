<?php

use App\Modules\Catalog\Http\Controllers\TreeController;
use App\Modules\Catalog\Http\Controllers\ProductController;

Route::get('/catalog/tree', [TreeController::class, 'get']);
Route::get('/products/{slug}', [ProductController::class, 'get']);
