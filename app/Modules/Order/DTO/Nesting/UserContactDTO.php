<?php

declare(strict_types=1);

namespace App\Modules\Order\DTO\Nesting;

use Spatie\LaravelData\Data;

final class UserContactDTO extends Data
{
    public function __construct(
        public string $fullName,
        public string $email,
        public string $phone,
    ) {}

    /**
      * Возвращает инстанс DTO из массива пользователя
      * провалидированного запроса
      * @return self
     */
    public static function fromInput(array $user): self
    {
        return new self(
            $user['fullName'],
            $user['email'],
            $user['phone'],
        );
    }
}
