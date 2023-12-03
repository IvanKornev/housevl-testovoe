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

    /**
     * Либо возвращает данные уже существующего пользователя,
     * либо регистрирует его в приложении
     *
     * @param UserContactDTO $data
     * @return array
     */
    public function registerIfThisIsGuest(UserContactDTO $data): array
    {
        $alreadyRegisteredUser = auth('sanctum')->user();
        if ($alreadyRegisteredUser) {
            return $alreadyRegisteredUser->toArray();
        }
        $receivingData = $data->toArray();
        $receivingData['password'] = Str::password(20);
        $results = $this->api->register($receivingData);
        return $results;
    }
}
