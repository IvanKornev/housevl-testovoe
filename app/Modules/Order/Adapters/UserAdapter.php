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

    public function get(int $id): array
    {
        $results = $this->api->get($id);
        return $results;
    }

    public function createWithToken(): array
    {
        $results = $this->api->createWithToken();
        return $results;
    }
}
