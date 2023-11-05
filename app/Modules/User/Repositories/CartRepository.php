<?php

namespace App\Modules\User\Repositories;

use App\Modules\User\Repositories\Contracts\ICartRepository;
use App\Modules\User\DTO\AddToCartDTO;

use App\Modules\User\Entities\CartDetail;
use App\Modules\User\Entities\Cart;

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
}
