<?php

namespace App\Modules\User\DTO;

use Spatie\LaravelData\Data;

final class LoginDTO extends Data
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
