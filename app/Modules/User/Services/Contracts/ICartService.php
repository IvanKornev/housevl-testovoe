<?php

namespace App\Modules\User\Services\Contracts;

use App\Modules\User\DTO\CartDTO;
use App\Modules\User\Entities\CartDetail;

interface ICartService
{
    /**
     * Возвращает запись о товаре, добавленной в корзину
     * @return CartDetail
     */
    public function store(CartDTO $operationData): CartDetail;
}
