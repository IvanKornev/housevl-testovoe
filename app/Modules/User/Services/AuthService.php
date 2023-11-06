<?php

namespace App\Modules\User\Services;

use Illuminate\Support\Facades\Hash;
use Exception;

use App\Modules\User\Services\Contracts\IAuthService;
use App\Modules\User\Entities\User;

use App\Modules\User\DTO\RegistrationDTO;
use App\Modules\User\DTO\LoginDTO;

class AuthService implements IAuthService
{
    /**
     * Сообщение ошибки авторизации
     *
     * @var string
     */
    private const AUTHORIZATION_ERROR = 'Произошла ошибка. Проверьте введенные данные';

    public function register(RegistrationDTO $formData): User
    {
        $emailIsDuplicate = !!User::where('email', $formData->email)->first();
        if ($emailIsDuplicate) {
            throw new Exception('Пользователь с такой почтой существует', 500);
        }
        $createdUser = User::create($formData->toArray());
        return $createdUser;
    }

    public function login(LoginDTO $formData): User
    {
        $user = User::where('email', $formData->email)->first();
        if (!$user) {
            throw new Exception(self::AUTHORIZATION_ERROR, 500);
        }
        $loginIsCorrect = Hash::check($formData->password, $user->password);
        if (!$loginIsCorrect) {
            throw new Exception(self::AUTHORIZATION_ERROR, 500);
        }
        return $user;
    }
}
