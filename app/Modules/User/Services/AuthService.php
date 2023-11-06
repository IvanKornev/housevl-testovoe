<?php

namespace App\Modules\User\Services;

use App\Modules\User\Services\Contracts\IAuthService;
use App\Modules\User\DTO\RegistrationDTO;
use App\Modules\User\Entities\User;
use Exception;

class AuthService implements IAuthService
{
    public function register(RegistrationDTO $formData): User
    {
        $emailIsDuplicate = !!User::where('email', $formData->email)->first();
        if ($emailIsDuplicate) {
            throw new Exception('Пользователь с такой почтой существует', 500);
        }
        $createdUser = User::create($formData->toArray());
        return $createdUser;
    }
}
