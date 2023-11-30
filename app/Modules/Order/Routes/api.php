<?php

use App\Modules\Order\Http\Controllers\OrderController;

Route::resource('orders', OrderController::class)->only(['store']);
