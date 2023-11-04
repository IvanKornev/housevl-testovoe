<?php

namespace App\Modules\User\Services;

use App\Modules\User\Services\Contracts\ICartService;
use App\Modules\User\DTO\AddToCartDTO;
use App\Modules\User\Entities\Cart;
use App\Modules\User\Entities\CartDetail;
use Exception;

final class CartService implements ICartService
{
    public function store(AddToCartDTO $operationData): CartDetail
    {
        $createdCart = null;
        if ($operationData->cartHash === null) {
            $createdCart = Cart::create();
            $operationData->cartHash = $createdCart->hash;
        }
        $searchQuery = Cart::query()->where('hash', $operationData->cartHash);
        $foundCart = $createdCart ?? $searchQuery->first();
        if (!$foundCart) {
            $message = 'Запрошенной в запросе корзины не '
                . 'существует или она была удалена';
            throw new Exception($message);
        }
        $createdRecord = CartDetail::create([
            'cart_id' => $foundCart->id,
            'product_id' => $operationData->productId,
            'quantity' => $operationData->quantity,
        ]);
        return $createdRecord;
    }
}
