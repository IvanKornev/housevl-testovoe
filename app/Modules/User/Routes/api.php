<?php

use App\Modules\User\Http\Controllers\CartController;

Route::get('/cart/add', [CartController::class, 'add']);
