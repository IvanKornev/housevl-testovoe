<?php

namespace App\Modules\User\Services;

use App\Modules\User\Services\Contracts\ICartService;
use App\Modules\User\DTO\AddToCartDTO;
use App\Modules\User\Entities\Cart;
use App\Modules\User\Entities\CartDetail;
use Exception;

final class CartService implements ICartService
{
    /*
        1) Проверяем, есть ли в DTO хеш корзины;
        2) Нет - создаем новую корзину и присваиваем её значение в DTO;
        3) Ищем по хешу айдишник корзины;
        4) Если ничего не нашли по переданному извне хешу - возвращаем ошибку
           о некорректности данных корзины ("Такой корзины не существует")
        5) Добавляем его + данные из DTO в таблицу деталей корзины (price достаем из
           найденного в БД товара);
    */

    public function store(AddToCartDTO $operationData): object
    {
        $createdCart = null;
        if ($operationData->cartHash === null) {
            $createdCart = Cart::create();
            $operationData->cartHash = $createdCart->hash;
        }
        $searchQuery = Cart::query()->where('hash', $operationData->cartHash);
        $foundCart = $createdCart ?? $searchQuery->first();
        if (!$foundCart) {
            $message = 'Запрошенной в запросе корзины не '
                . 'существует или она была удалена';
            throw new Exception($message);
        }
        CartDetail::create([
            'cart_id' => $foundCart->id,
            'product_id' => $operationData->productId,
            'quantity' => $operationData->quantity,
        ]);
        return new \stdClass;
    }
}
