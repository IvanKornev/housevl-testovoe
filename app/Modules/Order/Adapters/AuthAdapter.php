<?php

declare(strict_types=1);

namespace App\Modules\Order\Adapters;

use Illuminate\Support\Str;
use App\Modules\Order\DTO\Nesting\UserContactDTO;
use App\Modules\User\Api\Contracts\IAuthApi;

final class AuthAdapter
{
    private readonly IAuthApi $api;

    public function __construct(IAuthApi $api)
    {
        $this->api = $api;
    }

    public function registerIfThisIsGuest(UserContactDTO $data): ?array
    {
        if (auth('sanctum')->hasUser()) {
            return null;
        }
        $data->password = Str::password(20);
        $results = $this->api->register($data);
        return $results;
    }
}
