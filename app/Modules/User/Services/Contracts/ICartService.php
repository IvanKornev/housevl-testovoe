<?php

namespace App\Modules\User\Services\Contracts;

use App\Modules\User\DTO\AddToCartDTO;
use App\Modules\User\DTO\CartEditDTO;
use App\Modules\User\DTO\RemoveFromCartDTO;
use App\Modules\User\Entities\CartDetail;

interface ICartService
{
    /**
     * Возвращает запись о товаре, добавленной в корзину
     * @return CartDetail
     */
    public function store(AddToCartDTO $operationData): CartDetail;
    /**
     * Обновляет количество товара в корзине
     * @return CartDetail
     */
    public function update(CartEditDTO $operationData): CartDetail;
    /**
     * Удаляет товар из корзины
     * @return CartDetail
     */
    public function remove(RemoveFromCartDTO $operationData): CartDetail;
}
