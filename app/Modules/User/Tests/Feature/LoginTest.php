<?php

namespace App\Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\User\Tests\Feature\Traits\HasLoginData;
use Tests\TestCase;

final class LoginTest extends TestCase
{
    use RefreshDatabase, HasLoginData;

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
        $loginForm = $this->getLoginData($password);
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
        $loginForm = $this->getLoginData();
        $loginForm['password'] = fake()->password();
        $response = $this->json('POST', self::URL, $loginForm);
        $response->assertStatus(500);
    }
}
