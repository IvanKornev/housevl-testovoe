<?php

declare(strict_types=1);

namespace App\Modules\Order\Adapters;

use App\Modules\User\Api\Contracts\IUserApi;

final class UserAdapter
{
    private readonly IUserApi $api;

    public function __construct(IUserApi $api)
    {
        $this->api = $api;
    }

    /**
     * Получает пользователя по его ID
     *
     * @param int $id
     * @return array
     */
    public function get(int $id): array
    {
        $results = $this->api->get($id);
        return $results;
    }

    /**
     * Создает пользователя вместе с токеном
     *
     * @return array
     */
    public function createWithToken(): array
    {
        $results = $this->api->createWithToken();
        return $results;
    }
}
