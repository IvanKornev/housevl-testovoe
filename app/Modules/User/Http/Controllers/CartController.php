<?php

namespace App\Modules\User\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

use App\Modules\User\Http\Requests\AddToCartRequest;
use App\Modules\User\Http\Requests\CartEditRequest;

use App\Modules\User\DTO\CartDTO;
use App\Modules\User\Services\Contracts\ICartService;
use App\Modules\User\Transformers\CartDetailResource;

class CartController extends Controller
{
    private ICartService $service;

    public function __construct(ICartService $service)
    {
        $this->middleware('cart.hash')->except('store');
        $this->service = $service;
    }

    /**
     * Добавляет товар в корзину
     * @return JsonResponse
     */
    public function store(AddToCartRequest $request): JsonResponse
    {
        $operationData = CartDTO::fromRequest($request);
        $createdRecord = $this->service->store($operationData);
        return response()->json([
            'message' => 'Товар успешно добавлен в корзину',
            'record' => new CartDetailResource($createdRecord),
            'cartHash' => $createdRecord->cart->hash,
        ]);
    }

    /**
     * Обновляет товар в корзине
     * @return JsonResponse
     */
    public function update(CartEditRequest $request): JsonResponse
    {
        $operationData = CartDTO::fromRequest($request);
        return response()->json([
            'message' => 'Товар в корзине был успешно обновлен',
        ]);
    }
}
