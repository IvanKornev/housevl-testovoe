<?php

declare(strict_types=1);

namespace App\Modules\Order\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

use App\Modules\Order\Http\Requests\OrderConfirmationRequest;
use App\Modules\Order\Services\Contracts\IOrderService;
use App\Modules\Order\DTO\CreateOrderDTO;

class OrderController extends Controller
{
    private IOrderService $service;

    public function __construct(IOrderService $service)
    {
        $this->service = $service;
        $this->middleware('cart.hash');
    }

    /**
     * Создает заказ и возвращает URL
     * для его оплаты
     * @param OrderConfirmationRequest $request
     * @return JsonResponse
     */
    public function store(OrderConfirmationRequest $request): JsonResponse
    {
        $creatingOrder = CreateOrderDTO::fromRequest($request);
        $this->service->create($creatingOrder);
        $body = ['message' => 'Заказ был успешно создан'];
        return response()->json($body, 200);
    }
}
