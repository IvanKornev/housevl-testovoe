<?php

namespace App\Modules\User\Repositories\Contracts;

use App\Modules\User\DTO\CartDTO;
use App\Modules\User\Entities\CartDetail;
use App\Modules\User\Entities\Cart;

interface ICartRepository
{
    /**
     * Добавляет запись о корзине или обновляет уже существующую
     * @return CartDetail
     */
    public function store(CartDTO $data, Cart $cart): CartDetail;
}
