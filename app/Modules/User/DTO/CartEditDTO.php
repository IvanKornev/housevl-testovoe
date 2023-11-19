<?php

namespace App\Modules\User\DTO;

use Spatie\LaravelData\Data;
use Illuminate\Http\Request;

final class CartEditDTO extends Data
{
    public function __construct(
        public int $cartDetailsId,
        public int $quantity,
        public string $cartHash,
        public int | null $userId,
    ) {}

    /**
      *Возвращает инстанс DTO из объекта запроса
      * @return self
     */
    public static function fromRequest(Request $request): self
    {
        $body = $request->validated();
        $quantity = $body['quantity'];
        $cartHash = $request->header('Cart-Hash');
        $cartDetailsId = $request->route('cartDetailsId');
        $userId = $request->user()->id ?? null;
        return new self($cartDetailsId, $quantity, $cartHash, $userId);
    }
}
