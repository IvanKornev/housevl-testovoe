<?php

namespace App\Modules\User\Events;

use Illuminate\Queue\SerializesModels;
use App\Modules\User\Entities\Cart;
use Exception;

final class CartCreating
{
    use SerializesModels;

    /**
     * Ошибка о том, что для пользователя уже была
     * ранее заведена корзина и использовать нужно её
     *
     * @var string
     */
    private const NON_UNIQUE_CART_ERROR = 'У пользователя '
        . 'уже была заведена корзина';

    /**
     * Новый инстанс события сущности
     *
     * @return void
     */
    public function __construct(Cart $model)
    {
        if ($model->user_id !== null) {
            $this->checkExistenceOfOldUserCarts($model);
        }
    }

    /**
     * Проверяет, есть ли уже у пользователя корзина или нет
     *
     * @return void
    */
    private function checkExistenceOfOldUserCarts(Cart $model): void
    {
        $oldCarts = Cart::where('user_id', $model->user_id);
        if ($oldCarts->count() > 0) {
            throw new Exception(self::NON_UNIQUE_CART_ERROR);
        }
    }
}
