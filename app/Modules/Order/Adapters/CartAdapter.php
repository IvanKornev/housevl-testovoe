<?php

declare(strict_types=1);

namespace App\Modules\Order\Adapters;

use App\Modules\User\Api\Contracts\ICartApi;

final class CartAdapter
{
    private readonly ICartApi $api;

    public function __construct(ICartApi $api)
    {
        $this->api = $api;
    }

    public function get(int $id): array
    {
        $results = $this->api->get($id);
        return $results;
    }

    public function getByHash(string $hash): array
    {
        $results = $this->api->getByHash($hash);
        return $results;
    }

    public function delete(int $id): int
    {
        $results = $this->api->delete($id);
        return $results;
    }

    public function add(): array
    {
        $results = $this->api->add();
        return $results;
    }
}
