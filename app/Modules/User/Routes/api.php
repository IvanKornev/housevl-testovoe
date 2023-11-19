<?php

use App\Modules\User\Http\Controllers\CartController;
use App\Modules\User\Http\Controllers\AuthController;

Route::resource('cart', CartController::class)
    ->parameters(['cart' => 'cartDetailsId'])
    ->whereNumber('cartDetailsId')
    ->only(['store', 'update', 'destroy', 'index']);

$authModuleCallback = function () {
    Route::post('/registration', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')
        ->delete('/logout', [AuthController::class, 'logout']);
};
Route::prefix('auth')->group($authModuleCallback);
