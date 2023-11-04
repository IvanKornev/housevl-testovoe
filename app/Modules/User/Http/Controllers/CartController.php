<?php

namespace App\Modules\User\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CartController extends Controller
{
    /**
     * Добавляет товар в корзину
     * @return JsonResponse
     */
    public function add(): JsonResponse
    {
        return response()->json([
            'message' => 'Товар успешно добавлен в корзину',
        ]);
    }
}
