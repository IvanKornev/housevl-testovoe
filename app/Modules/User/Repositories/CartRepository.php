<?php

namespace App\Modules\User\Repositories;

use App\Modules\User\Repositories\Contracts\ICartRepository;
use App\Modules\User\DTO\AddToCartDTO;

use App\Modules\User\Entities\CartDetail;
use App\Modules\User\Entities\Cart;
use Exception;

final class CartRepository implements ICartRepository
{
    /**
     * Сообщение о некорректной корзине
     *
     * @var string
     */
    private const INVALID_CART_MESSAGE = 'Запрошенной в запросе корзины не '
        . 'существует или она была удалена';

    public function store(AddToCartDTO $data, Cart $cart): CartDetail
    {
        if (!$cart) {
            throw new Exception(self::INVALID_CART_MESSAGE);
        }
        $record = CartDetail::with('product')->create([
            'cart_id' => $cart->id,
            'product_id' => $data->productId,
            'quantity' => $data->quantity,
        ]);
        return $record;
    }
}
