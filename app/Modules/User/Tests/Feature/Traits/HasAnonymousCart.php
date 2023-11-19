<?php

namespace App\Modules\User\Tests\Feature\Traits;

use App\Modules\User\Entities\CartDetail;
use App\Modules\User\Entities\Cart;

trait HasAnonymousCart
{
    /**
     * Получает запись из новосозданной
     * анонимной корзины
     *
     * @return CartDetail
     */
    private function getDetailFromAnonymousCart(): CartDetail
    {
        Cart::factory()->hasDetails()->create();
        $detail = CartDetail::join('carts', 'carts.id', '=', 'cart_details.cart_id')
            ->whereNull('carts.user_id')
            ->first();
        return $detail;
    }
}
