<?php

declare(strict_types=1);

namespace App\Modules\User\Api;

use App\Modules\User\Api\Contracts\ICartApi;
use App\Modules\User\Entities\Cart;
use Exception;

final class CartApi implements ICartApi
{
    public function get(int $id = 1): array
    {
        return Cart::findOrFail($id)->toArray();
    }

    public function getByHash(string $hash): array
    {
        return Cart::where('hash', $hash)
            ->with('details')
            ->first()
            ->toArray();
    }

    public function delete(int $id): int
    {
        $foundCart = Cart::where('id', $id);
        if (!$foundCart) {
            throw new Exception('Корзины не существует');
        }
        return $foundCart->delete();
    }

    public function add(): array
    {
        return Cart::create()->toArray();
    }
}
