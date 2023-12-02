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
}
