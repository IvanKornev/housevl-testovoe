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
    private array $body;

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
        $this->setBody();
        $this->adapter = app(CartAdapter::class);
        $gotCart = $this->adapter->get(1);
        $this->headers = ['Cart-Hash' => $gotCart['hash']];
    }


    /**
     * Устанавливает body для каждого из запросов
     *
     * @return void
     */
    private function setBody(): void
    {
        $this->body = [
            'user' => [
                'fullName' => $this->faker->word(),
                'email' => $this->faker->email(),
                'phone' => $this->faker->e164PhoneNumber(),
            ],
        ];
    }

    /**
     * Тест, успешно создающий заказ для
     * неавторизованного пользователя
     *
     * @return void
     */
    public function testConfirmsOrderForUnauthorizedUser(): void
    {
        $response = $this->json('POST', self::URL, $this->body, $this->headers);
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
     * Проверяет возврат ошибки при пустой корзине
     *
     * @return void
     */
    public function testReturnsErrorIfCartIsAlreadyEmpty(): void
    {
        $addedCart = $this->adapter->add();
        $response = $this->json('POST', self::URL, $this->body, [
            'Cart-Hash' => $addedCart['hash'],
        ]);
        $content = json_decode($response->getContent(), true);
        $expectedMessage = 'Заказ не может быть создан для пустой корзины';
        $this->assertEquals($expectedMessage, $content['message']);
    }
}
