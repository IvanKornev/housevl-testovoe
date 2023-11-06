<?php

namespace App\Modules\User\Services;

use App\Modules\User\Services\Contracts\IAuthService;
use App\Modules\User\DTO\RegistrationDTO;
use App\Modules\User\Entities\User;

class AuthService implements IAuthService
{
    public function register(RegistrationDTO $formData): User
    {
        $createdUser = User::create($formData->toArray());
        return $createdUser;
    }
}
