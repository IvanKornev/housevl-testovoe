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
}
