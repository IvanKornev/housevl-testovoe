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

    /**
      * Возвращает инстанс DTO из массива пользователя
      * провалидированного запроса
      * @return self
     */
    public static function fromArray(array $user): self
    {
        return new self(
            $user['name'],
            $user['surname'],
            $user['patronymic'],
            $user['email'],
            $user['phone'],
        );
    }
}
