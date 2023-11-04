<?php

namespace App\Modules\User\Services\Contracts;

use App\Modules\User\DTO\AddToCartDTO;

interface ICartService
{
    /**
     * Возвращает товар, добавленный в корзину
     * @return object
     */
    public function store(AddToCartDTO $operationData): object;
}
