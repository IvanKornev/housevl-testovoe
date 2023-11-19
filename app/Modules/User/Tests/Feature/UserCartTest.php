<?php

namespace App\Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Modules\User\Entities\CartDetail;
use App\Modules\User\Entities\User;
use App\Shared\Tests\TestCase;

final class UserCartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Базовый URL вызываемого эндпоинта
     *
     * @var string
     */
    private const BASE_URL = '/api/cart';

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
    }

    /**
     * Проверяет добавление первого товара и создание
     * пользовательской корзины
     *
     * @return void
     */
    public function testAddsFirstItemToUserCart(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('api')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];
        $body = ['productId' => 1];
        $response = $this->json('POST', self::BASE_URL, $body, $headers);
        $content = json_decode($response->getContent(), true);
        $addedItem = CartDetail::where('id', $content['record']['id'])->first();
        $this->assertEquals($user->id, $addedItem->cart->user_id);
        $this->assertEquals($content['cartHash'], $addedItem->cart->hash);
    }
}
