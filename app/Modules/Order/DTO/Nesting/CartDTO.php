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
}
