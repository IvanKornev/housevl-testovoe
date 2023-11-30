<?php

declare(strict_types=1);

namespace App\Modules\Cart\Api;

use App\Modules\User\Entities\Cart;

final class CartApi
{
    public function get(int $id): array
    {
        return Cart::findOrFail($id)->toArray();
    }
}
