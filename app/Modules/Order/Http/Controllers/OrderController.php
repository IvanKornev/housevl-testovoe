<?php

declare(strict_types=1);

namespace App\Modules\Order\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

use App\Modules\Order\Http\Requests\CreateOrderRequest;
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
     *
     * @param CreateOrderRequest $request
     * @return JsonResponse
     */
    public function store(CreateOrderRequest $request): JsonResponse
    {
        $creatingOrder = CreateOrderDTO::fromRequest($request);
        $paymentUrl = $this->service->create($creatingOrder);
        $body = [
            'message' => 'Заказ был успешно создан',
            'paymentUrl' => $paymentUrl,
        ];
        return response()->json($body, 200);
    }
}
