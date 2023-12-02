<?php

declare(strict_types=1);

namespace App\Modules\User\Api\Contracts;

interface IUserApi
{
    /**
     * Возвращает пользователя по ID
     *
     * @param int $id
     * @return array
    */
    public function get(int $id = 1): array;
    /**
     * Создает пользователя вместе с токеном доступа
     * @return array
    */
    public function createWithToken(): array;
}
