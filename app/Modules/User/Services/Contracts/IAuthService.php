<?php

namespace App\Modules\User\Services\Contracts;

use App\Modules\User\DTO\RegistrationDTO;
use App\Modules\User\Entities\User;

interface IAuthService
{
    /**
     * Регистрирует нового пользователя
     * @return User
     */
    public function register(RegistrationDTO $formData): User;
}
