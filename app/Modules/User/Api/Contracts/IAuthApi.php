<?php

declare(strict_types=1);

namespace App\Modules\User\Api\Contracts;

interface IAuthApi
{
    /**
     * Регистрирует нового пользователя в системе
     *
     * @param object $data
     * @return array
    */
    public function register(object $data): array;
}
