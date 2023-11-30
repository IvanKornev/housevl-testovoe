<?php

namespace App\Modules\Order\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

use App\Modules\Order\Http\Requests\OrderConfirmationRequest;

class OrderController extends Controller
{
    /**
     * Подтверждает заказ и возвращает URL
     * для его оплаты
     * @param OrderConfirmationRequest $request
     * @return JsonResponse
     */
    public function store(OrderConfirmationRequest $request): JsonResponse
    {
        return response()->json(['message' => 'it\'s ok'], 200);
    }
}
