<?php

use App\Modules\User\Http\Controllers\CartController;

Route::resource('cart', CartController::class)
    ->parameters(['cart' => 'cartDetailsId'])
    ->whereNumber('cartDetailsId')
    ->only(['store', 'update', 'destroy']);
