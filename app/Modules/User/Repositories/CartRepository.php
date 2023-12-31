<?php

namespace App\Modules\User\Repositories;

use App\Modules\User\Repositories\Contracts\ICartRepository;
use App\Modules\User\DTO\AddToCartDTO;
use App\Modules\User\DTO\CartEditDTO;
use App\Modules\User\DTO\RemoveFromCartDTO;

use App\Modules\User\Entities\CartDetail;
use App\Modules\User\Entities\Cart;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;

final class CartRepository implements ICartRepository
{
    public function store(AddToCartDTO $data, Cart $cart): CartDetail
    {
        $existingRecord = CartDetail::where('product_id', $data->productId)
            ->where('cart_id', $cart->id)
            ->first();
        if ($existingRecord) {
            $newQuantity = $data->quantity + $existingRecord->quantity;
            $existingRecord->quantity = $newQuantity;
            $existingRecord->save();
            return $existingRecord;
        }
        $createdRecord = CartDetail::with('product')->create([
            'cart_id' => $cart->id,
            'product_id' => $data->productId,
            'quantity' => $data->quantity,
        ]);
        return $createdRecord;
    }

    public function findOrCreate(AddToCartDTO $operationData): Cart | null
    {
        $createdCart = null;
        if ($operationData->cartHash === null) {
            $createdCart = Cart::create(['user_id' => $operationData->userId]);
            $operationData->cartHash = $createdCart->hash;
        }
        $searchQuery = Cart::query()
            ->where('hash', $operationData->cartHash)
            ->where('user_id', $operationData->userId);
        $foundCart = $createdCart ?? $searchQuery->first();
        return $foundCart;
    }

    public function get(string $cartHash): Cart | null
    {
        $cartQuery = Cart::query()->where('hash', $cartHash);
        $currentUser = auth('sanctum')->user();
        if (!$cartHash && $currentUser) {
            $cartQuery->orWhere('user_id', $currentUser->user_id);
        }
        $cart = $cartQuery->first();
        return $cart;
    }

    public function getDetail(CartEditDTO | RemoveFromCartDTO $data): CartDetail
    {
        $record = CartDetail::join('carts', 'carts.id', '=', 'cart_details.cart_id')
            ->where('carts.user_id', $data->userId)
            ->where('carts.hash', $data->cartHash)
            ->where('cart_details.id', $data->cartDetailsId)
            ->first();
        if (!$record) {
            throw new NotFoundHttpException('Такой записи не существует');
        }
        return $record;
    }
}
