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
        $response = $this->json('DELETE', self::URL);
        $response->assertStatus(200);
    }
}
