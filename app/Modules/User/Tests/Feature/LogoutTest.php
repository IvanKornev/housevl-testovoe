<?php

namespace App\Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\User\Entities\User;
use Tests\TestCase;

final class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * URL вызываемого эндпоинта
     *
     * @var string
     */
    private const URL = '/api/auth/logout';

    /**
     * Проверяет правильность выхода из системы
     *
     * @return void
     */
    public function testChecksLogout(): void
    {
        $user = User::factory()
            ->state(fn ($state) => [...$state, 'password' => '123'])
            ->create();
        $loginForm = ['email' => $user->email, 'password' => '123'];
        $loginUrl = '/api/auth/login';
        $loginResponse = $this->json('POST', $loginUrl, $loginForm);
        $content = json_decode($loginResponse->getContent(), true);
        $logoutResponse = $this->json('DELETE', self::URL, [], [
            'Authorization' => 'Bearer ' . $content['token'],
        ]);
        $logoutResponse->assertStatus(200);
    }

    /**
     * Проверяет наличие ошибки, которая возвращается при отсутствии
     * Authorization header'а
     *
     * @return void
     */
    public function testReturnsErrorIfAuthorizationHeaderIsMissing(): void
    {
        $response = $this->json('DELETE', self::URL);
        $response->assertStatus(401);
        $content = json_decode($response->getContent(), true);
        $this->assertEquals('Вы не авторизованы', $content['message']);
    }
}
