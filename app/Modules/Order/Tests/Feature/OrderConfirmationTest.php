<?php

declare(strict_types=1);

namespace App\Modules\Order\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Order\Adapters\CartAdapter;
use App\Shared\Tests\TestCase;

final class OrderConfirmationTest extends TestCase
{
    use RefreshDatabase;

    private CartAdapter $adapter;

    /**
     * URL вызываемого эндпоинта
     *
     * @var string
     */
    private const URL = '/api/orders';

    /**
     * Поднимает тесты, а также заполняет БД
     * минимальными значениями
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed --class=TestDatabaseSeeder');
        $this->adapter = app(CartAdapter::class);
    }

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
        $gotCart = $this->adapter->get(1);
        $headers = ['Cart-Hash' => $gotCart['hash']];
        $response = $this->json('POST', self::URL, [], $headers);
        $response->assertStatus(422);
    }

    /**
     * Проверяет возврат ошибки при отсутствии
     * хеша корзины
     *
     * @return void
     */
    public function testFailsWithoutCartHash(): void
    {
        $response = $this->json('POST', self::URL);
        $response->assertStatus(500);
    }
}
