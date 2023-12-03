<?php

declare(strict_types=1);

namespace App\Modules\User\Api;

use App\Modules\User\Api\Contracts\IAuthApi;
use App\Modules\User\Services\Contracts\IAuthService;
use App\Modules\User\DTO\RegistrationDTO;

final class AuthApi implements IAuthApi
{
    private IAuthService $service;

    public function __construct(IAuthService $service)
    {
        $this->service = $service;
    }

    public function register(array $data): array
    {
        $receivingData = RegistrationDTO::from($data);
        $createdUser = $this->service->register($receivingData);
        return $createdUser->toArray();
    }
}
