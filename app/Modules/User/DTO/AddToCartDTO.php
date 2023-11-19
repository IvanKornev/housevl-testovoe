<?php

namespace App\Modules\User\DTO;

use Spatie\LaravelData\Data;
use Illuminate\Http\Request;

final class AddToCartDTO extends Data
{
    public function __construct(
        public int $productId,
        public int $quantity,
        public int | null $userId,
        public string | null $cartHash,
    ) {}

    /**
      *Возвращает инстанс DTO из объекта запроса
      * @return self
     */
    public static function fromRequest(Request $request): self
    {
        $body = $request->validated();
        $quantity = $body['quantity'] ?? 1;
        $cartHash = null;
        if ($request->hasHeader('Cart-Hash')) {
            $cartHash = $request->header('Cart-Hash');
        }
        $productId = $body['productId'];
        $userId = $request->user()->id ?? null;
        return new self($productId, $quantity, $userId, $cartHash);
    }
}
