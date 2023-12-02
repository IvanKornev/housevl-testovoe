<?php

declare(strict_types=1);

namespace App\Modules\Order\DTO\Nesting;

use Spatie\LaravelData\Data;

final class CartDTO extends Data
{
    public function __construct(
        public string $hash,
        public int $id,
        public array $details = [],
    ) {}

    /**
      * Возвращает инстанс DTO из массива корзины,
      * получаемого через БД
      * @return self
     */
    public static function fromArray(array $cart): self
    {
        return new self(
            $cart['hash'],
            $cart['id'],
            $cart['details'],
        );
    }
}
