<?php

namespace App\Modules\User\DTO;

use Spatie\LaravelData\Data;
use Illuminate\Http\Request;

final class AddToCartDTO extends Data
{
    public function __construct(
        public int $productId,
        public int $quantity,
        public string | null $cartHash,
    ) {}

    /**
      *Возвращает инстанс DTO из объекта запроса
      * @return self
     */
    public static function fromRequest(Request $request): self
    {
        $validatedFields = $request->validated();
        $quantity = $validatedFields['quantity'] ?? 1;
        $cartHash = null;
        if ($request->hasHeader('Cart-Hash')) {
            $cartHash = $request->header('Cart-Hash');
        }
        $productId = $validatedFields['productId'];
        return new self($productId, $quantity, $cartHash);
    }
}
