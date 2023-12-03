<?php

declare(strict_types=1);

namespace App\Modules\User\Api\Contracts;

interface IAuthApi
{
    /**
     * Регистрирует нового пользователя в системе
     *
     * @param array $data
     * @return array
    */
    public function register(array $data): array;
}
