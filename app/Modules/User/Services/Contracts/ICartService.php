<?php

namespace App\Modules\User\Services\Contracts;

use App\Modules\User\DTO\AddToCartDTO;
use App\Modules\User\Entities\CartDetail;

interface ICartService
{
    /**
     * Возвращает запись о товаре, добавленной в корзину
     * @return CartDetail
     */
    public function store(AddToCartDTO $operationData): CartDetail;
}
