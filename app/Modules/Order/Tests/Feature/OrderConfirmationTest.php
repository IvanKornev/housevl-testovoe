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
     * Тест, успешно создающий заказ для
     * неавторизованного пользователя
     *
     * @return void
     */
    public function testConfirmsOrderForUnauthorizedUser(): void
    {
        $data = [
            'user' => [
                'fullName' => $this->faker->word(),
                'email' => $this->faker->email(),
                'phone' => $this->faker->e164PhoneNumber(),
            ],
        ];
        $response = $this->json('POST', self::URL, $data, $this->headers);
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $cleanedCartCount = 0;
        $this->assertCount($cleanedCartCount, $content['meta']['cart']['items']);
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

    /**
     * Проверяет возврат ошибки при уже
     * опустошенной корзине
     *
     * @return void
     */
    public function testReturnsErrorIfCartIsAlreadyEmpty(): void
    {
        $response = $this->json('POST', self::URL);
        $content = json_decode($response->getContent(), true);
        $expectedMessage = 'Заказ не может быть создан для пустой корзины';
        $this->assertEquals($expectedMessage, $content['message']);
    }
}
