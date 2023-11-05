<?php

use App\Modules\User\Http\Controllers\CartController;

Route::resource('cart', CartController::class)
    ->parameters([
        'cart' => 'productId'
    ])
    ->whereNumber('productId')
    ->only(['store', 'update']);
