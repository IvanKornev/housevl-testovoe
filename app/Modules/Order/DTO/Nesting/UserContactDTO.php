<?php

declare(strict_types=1);

namespace App\Modules\Order\DTO\Nesting;

use Spatie\LaravelData\Data;

final class UserContactDTO extends Data
{
    public function __construct(
        public string $name,
        public string $surname,
        public string $patronymic,
        public string $email,
        public string $phone,
    ) {}
}
