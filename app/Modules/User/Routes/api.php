<?php

use App\Modules\User\Http\Controllers\CartController;

Route::resources(['cart' => CartController::class]);
