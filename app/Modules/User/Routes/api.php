<?php

use App\Modules\User\Http\Controllers\CartController;

Route::resource('cart', CartController::class)->only(['store', 'update']);
