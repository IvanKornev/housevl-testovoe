<?php

namespace App\Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

use App\Modules\User\Http\Requests\AddToCartRequest;
use App\Modules\User\Http\Requests\CartEditRequest;

use App\Modules\User\DTO\AddToCartDTO;
use App\Modules\User\DTO\CartEditDTO;
use App\Modules\User\DTO\RemoveFromCartDTO;

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
        $operationData = AddToCartDTO::fromRequest($request);
        $record = $this->service->store($operationData);
        return response()->json([
            'message' => 'Товар успешно добавлен в корзину',
            'record' => new CartDetailResource($record),
            'cartHash' => $record->cart->hash,
        ]);
    }

    /**
     * Обновляет товар в корзине
     * @return JsonResponse
     */
    public function update(CartEditRequest $request): JsonResponse
    {
        $operationData = CartEditDTO::fromRequest($request);
        $updatedRecord = $this->service->update($operationData);
        return response()->json([
            'message' => 'Товар в корзине был успешно обновлен',
            'record' => new CartDetailResource($updatedRecord),
        ]);
    }

    /**
     * Получает полную корзину
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $cartHash = $request->header('Cart-Hash');
        $result = $this->service->getAll($cartHash);
        return response()->json([
            'message' => 'Корзина успешно получена',
            'data' => [
                'items' => CartDetailResource::collection($result['items']),
                'totalPrice' => $result['totalPrice'],
            ],
        ]);
    }

    /**
     * Удаляет товар из корзины
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $operationData = RemoveFromCartDTO::fromRequest($request);
        [$removedRecord, $cartHash] = $this->service->remove($operationData);
        return response()->json([
            'message' => 'Товар был успешно удален из корзины',
            'record' => new CartDetailResource($removedRecord),
            'cartHash' => $cartHash,
        ]);
    }
}
