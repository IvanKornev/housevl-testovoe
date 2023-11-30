<?php

declare(strict_types=1);

namespace App\Modules\Order\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Shared\Tests\TestCase;

final class OrderConfirmationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * URL вызываемого эндпоинта
     *
     * @var string
     */
    private const URL = '/api/orders';

    /**
     * Тест, успешно оформляющий заказ для
     * неавторизованного пользователя
     *
     * @return void
     */
    public function testConfirmsOrderForUnauthorizedUser(): void
    {
        $response = $this->json('POST', self::URL);
        $response->assertStatus(200);
    }

    /**
     * Проверяет возврат ошибки при провале валидации
     * запроса от неавторизованного пользователя
     *
     * @return void
     */
    public function testFailsUnauthorizedUserValidation(): void
    {
        $response = $this->json('POST', self::URL);
        $response->assertStatus(422);
    }
}
