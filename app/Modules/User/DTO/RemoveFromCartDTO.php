<?php

namespace App\Modules\User\DTO;

use Spatie\LaravelData\Data;
use Illuminate\Http\Request;

final class RemoveFromCartDTO extends Data
{
    public function __construct(
        public int $cartDetailsId,
        public string $cartHash,
    ) {}

    /**
      *Возвращает инстанс DTO из объекта запроса
      * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->route('cartDetailsId'),
            $request->header('Cart-Hash'),
        );
    }
}
