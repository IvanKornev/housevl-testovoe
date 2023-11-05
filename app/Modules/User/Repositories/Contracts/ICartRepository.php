<?php

namespace App\Modules\User\Repositories\Contracts;

use App\Modules\User\DTO\AddToCartDTO;
use App\Modules\User\Entities\CartDetail;
use App\Modules\User\Entities\Cart;

interface ICartRepository
{
    /**
     * Добавляет запись о корзине или обновляет уже существующую
     * @return CartDetail
     */
    public function store(AddToCartDTO $data, Cart $cart): CartDetail;
}
