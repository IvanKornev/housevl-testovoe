<?php

namespace App\Modules\User\DTO;

use Spatie\LaravelData\Data;

final class RegistrationDTO extends Data
{
    public function __construct(
        public string $name,
        public string $surname,
        public string $password,
        public string $patronymic,
        public string $email,
        public string $phone,
    ) {}
}
