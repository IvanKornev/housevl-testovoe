<?php

namespace App\Modules\User\Tests\Feature\Traits;

use App\Modules\User\Entities\User;

trait HasLoginData
{
    /**
     * Создает пользователя, и возвращает данные для его
     * успешной авторизации
     *
     * @return array
     */
    private function getLoginData(string $password = '123'): array
    {
        $user = User::factory()
            ->state(fn ($state) => [...$state, 'password' => $password])
            ->create();
        $results = ['email' => $user->email, 'password' => $password];
        return $results;
    }
}
