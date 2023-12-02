<?php

declare(strict_types=1);

namespace App\Modules\User\Api;

use App\Modules\User\Api\Contracts\ICartApi;
use App\Modules\User\Entities\Cart;

final class CartApi implements ICartApi
{
    public function get(int $id): array
    {
        return Cart::findOrFail($id)->toArray();
    }

    public function delete(string $hash): int
    {
        return Cart::where('hash', $hash)->delete();
    }
}
