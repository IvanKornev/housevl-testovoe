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
        $user = $this->prepareUser($password);
        $loginForm = ['email' => $user->email, 'password' => $password];
        $response = $this->json('POST', self::URL, $loginForm);
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $this->assertIsString($content['token']);
    }

    /**
     * Проверяет возврат ошибки при провале валидации
     *
     * @return void
     */
    public function testFailsRequestValidation(): void
    {
        $response = $this->json('POST', self::URL);
        $response->assertStatus(422);
    }

    /**
     * Проверяет возврат ошибки для пользователя с
     * с несуществующей почтой
     *
     * @return void
     */
    public function testFailsUserEmailValidation(): void
    {
        $loginForm = ['email' => '123@emal.ru', 'password' => '1'];
        $response = $this->json('POST', self::URL, $loginForm);
        $response->assertStatus(500);
    }

    /**
     * Проверяет возврат ошибки при вводе
     * неправильного пароля
     *
     * @return void
     */
    public function testFailsPasswordValidation(): void
    {
        $user = $this->prepareUser();
        $loginForm = ['email' => $user->email, 'password' => '1'];
        $response = $this->json('POST', self::URL, $loginForm);
        $response->assertStatus(500);
    }

    /**
     * Создает пользователя, данные которого будут
     * использоваться для заполнения формы авторизации
     *
     * @return User
     */
    private function prepareUser(string $password = '123'): User
    {
        $user = User::factory()
            ->state(fn ($state) => [...$state, 'password' => $password])
            ->create();
        return $user;
    }
}
