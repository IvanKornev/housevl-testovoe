<?php

namespace App\Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Shared\Tests\TestCase;

use App\Modules\User\Tests\Feature\Traits\HasLoginData;

final class LogoutTest extends TestCase
{
    use RefreshDatabase, HasLoginData;

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
        $loginForm = $this->getLoginData();
        $loginResponse = $this->json('POST', '/api/auth/login', $loginForm);
        $loginContent = json_decode($loginResponse->getContent(), true);
        $token = 'Bearer ' . $loginContent['token'];
        $logoutResponse = $this->json('DELETE', self::URL, [], [
            'Authorization' => $token,
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
