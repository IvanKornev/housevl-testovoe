<?php

declare(strict_types=1);

namespace App\Modules\Order\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Modules\Order\Adapters\CartAdapter;
use App\Shared\Tests\TestCase;

final class OrderConfirmationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private CartAdapter $adapter;
    private array $headers;

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
        $gotCart = $this->adapter->get(1);
        $this->headers = ['Cart-Hash' => $gotCart['hash']];
    }

    /**
     * Тест, успешно оформляющий заказ для
     * неавторизованного пользователя
     *
     * @return void
     */
    public function testConfirmsOrderForUnauthorizedUser(): void
    {
        $data = [
            'user' => [
                'fullname' => $this->faker->word(),
                'email' => $this->faker->email(),
                'phone' => $this->faker->e164PhoneNumber(),
            ],
        ];
        $response = $this->json('POST', self::URL, $data, $this->headers);
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
        $response = $this->json('POST', self::URL, [], $this->headers);
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
