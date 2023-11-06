<?php

namespace App\Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\User\Entities\User;
use Tests\TestCase;

final class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * URL вызываемого эндпоинта
     *
     * @var string
     */
    private const URL = '/api/auth/login';

    /**
     * Проверяет фичу авторизации
     *
     * @return void
     */
    public function testAuthorizesUserInTheSystem(): void
    {
        $password = fake()->password();
        $user = User::factory()
            ->state(fn ($state) => [...$state, 'password' => $password])
            ->create();
        $loginForm = ['email' => $user->email, 'password' => $password];
        $response = $this->json('POST', self::URL, $loginForm);
        $response->assertStatus(200);
    }

    /**
     * Проверяет возврат ошибки при провале валидации
     *
     * @return void
     */
    public function testFailsRequestValidation(): void
    {
        $response = $this->json('POST', self::URL,);
        $response->assertStatus(422);
    }

}
