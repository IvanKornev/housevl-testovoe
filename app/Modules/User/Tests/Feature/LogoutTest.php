<?php

namespace App\Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $response = $this->json('DELETE', self::URL, []);
        $response->assertStatus(200);
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
