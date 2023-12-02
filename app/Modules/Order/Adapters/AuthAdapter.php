<?php

declare(strict_types=1);

namespace App\Modules\Order\Adapters;

use App\Modules\User\Api\Contracts\IUserApi;
use App\Modules\Order\DTO\CreateOrderDTO;

final class AuthAdapter
{
    private readonly IUserApi $api;

    public function __construct(IUserApi $api)
    {
        $this->api = $api;
    }
}
