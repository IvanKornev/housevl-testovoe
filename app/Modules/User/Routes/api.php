<?php

use App\Modules\User\Http\Controllers\CartController;

Route::post('/cart/add', [CartController::class, 'add']);
