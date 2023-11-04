<?php

namespace App\Modules\User\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

use App\Modules\User\Services\Contracts\ICartService;
use App\Modules\User\Http\Requests\AddToCartRequest;
use App\Modules\User\Transformers\CartDetailResource;
use App\Modules\User\DTO\AddToCartDTO;

class CartController extends Controller
{
    private ICartService $service;

    public function __construct(ICartService $service)
    {
        $this->service = $service;
    }

    /**
     * Добавляет товар в корзину
     * @return JsonResponse
     */
    public function store(AddToCartRequest $request): JsonResponse
    {
        $operationData = AddToCartDTO::fromRequest($request);
        $createdRecord = $this->service->store($operationData);
        return response()->json([
            'message' => 'Товар успешно добавлен в корзину',
            'record' => new CartDetailResource($createdRecord),
        ]);
    }
}
