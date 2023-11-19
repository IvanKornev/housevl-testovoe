<?php

namespace App\Modules\User\Repositories\Contracts;

use App\Modules\User\DTO\AddToCartDTO;
use App\Modules\User\DTO\CartEditDTO;
use App\Modules\User\DTO\RemoveFromCartDTO;

use App\Modules\User\Entities\CartDetail;
use App\Modules\User\Entities\Cart;

interface ICartRepository
{
    /**
     * Добавляет запись о корзине или обновляет уже существующую
     * @return CartDetail
     */
    public function store(AddToCartDTO $data, Cart $cart): CartDetail;
    /**
     * Получает корзину по её хешу (или, если его нет, по текущему
     * пользователю)
     *
     * @return Cart | null
     */
    public function get(string $cartHash): Cart | null;
    /**
     * Получает запись корзины после проверки хеша и ID
     * @return CartDetail
     */
    public function getDetail(CartEditDTO | RemoveFromCartDTO $data): CartDetail;
}
