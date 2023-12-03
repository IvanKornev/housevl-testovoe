<?php

declare(strict_types=1);

namespace App\Modules\Order\Tests\Feature;

use Illuminate\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Modules\Order\Adapters\CartAdapter;
use App\Modules\Order\Adapters\UserAdapter;
use App\Modules\Order\Entities\Order;
use App\Shared\Tests\TestCase;

final class OrderConfirmationTest extends TestCase
{
    use RefreshDatabase;

    private CartAdapter $cartAdapter;
    private UserAdapter $userAdapter;

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

        $this->cartAdapter = app(CartAdapter::class);
        $gotCart = $this->cartAdapter->get(1);
        $this->headers = ['Cart-Hash' => $gotCart['hash']];

        $this->userAdapter = app(UserAdapter::class);
        $this->body = ['user' => $this->userAdapter->get(1)];
    }

    /**
     * Тест, успешно создающий заказ для
     * неавторизованного пользователя
     *
     * @return void
     */
    public function testConfirmsOrderForUnauthorizedUser(): void
    {
        $this->body['user']['email'] = 'guest@mail.ru';
        $response = $this->json('POST', self::URL, $this->body, $this->headers);
        $this->checkCreatedOrderResponse($response);
    }

    /**
     * Тест, успешно создающий заказ для
     * авторизованного пользователя
     *
     * @return void
     */
    public function testConfirmsOrderForAuthorizedUser(): void
    {
        ['token' => $token] = $this->userAdapter->createWithToken();
        $response = $this->json('POST', self::URL, [], [
            'Authorization' => "Bearer $token",
            ...$this->headers,
        ]);
        $this->checkCreatedOrderResponse($response);
    }

    private function checkCreatedOrderResponse(TestResponse $response): void
    {
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $validPaymentUrl = filter_var($content['paymentUrl'], FILTER_VALIDATE_URL);
        $this->assertIsString($validPaymentUrl);
        $this->assertCount(0, $content['meta']['cart']['items']);
        $createdOrder = Order::where('payment_url', $validPaymentUrl)->first();
        $this->assertIsObject($createdOrder);
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
        $addedCart = $this->cartAdapter->add();
        $response = $this->json('POST', self::URL, $this->body, [
            'Cart-Hash' => $addedCart['hash'],
        ]);
        $content = json_decode($response->getContent(), true);
        $expectedMessage = 'Заказ не может быть создан для пустой корзины';
        $this->assertEquals($expectedMessage, $content['message']);
    }
}
