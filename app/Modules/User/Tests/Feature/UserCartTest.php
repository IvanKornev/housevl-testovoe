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
     * Тело запроса, одинаковое для всех запросов
     *
     * @var array
     */
    private const BODY = ['productId' => 1];

    /**
     * Сообщение, которое показывается при попытке
     * создать вторую корзину для пользователя
     *
     * @var string
     */
    private const NON_UNIQUE_CART_ERROR = 'У пользователя '
        . 'уже была заведена корзина';

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
        $response = $this->json('POST', self::BASE_URL, self::BODY, [
            'Authorization' => "Bearer $token",
        ]);
        $content = json_decode($response->getContent(), true);
        $addedItem = CartDetail::where('id', $content['record']['id'])->first();
        $this->assertEquals($user->id, $addedItem->cart->user_id);
        $this->assertEquals($content['cartHash'], $addedItem->cart->hash);
    }

    /**
     * Проверяет возврат ошибки при создании корзины
     * для пользователя, который уже имеет корзину
     *
     * @return void
     */
    public function testReturnsErrorIfUserAlreadyHasCart(): void
    {
        $user = User::factory()->hasCart()->create();
        $token = $user->createToken('api')->plainTextToken;
        $response = $this->json('POST', self::BASE_URL, self::BODY, [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(500);
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(self::NON_UNIQUE_CART_ERROR, $content['message']);
    }

    /**
     * Проверяет создание новой корзины
     * пользователя после удаления старой
     * (вследствие удаления последнего товара из неё)
     *
     * @return void
     */
    public function testCreatesNewCartAfterRemovingTheOldOne(): void
    {
        $detail = CartDetail::first();
        $token = User::find($detail->cart->user_id)->createToken('api');
        $url = self::BASE_URL . '/' . $detail->id;
        $this->json('DELETE', $url, [], [
            'Cart-Hash' => $detail->cart->hash,
            'Authorization' => "Bearer {$token->plainTextToken}",
        ]);
        $response = $this->json('POST', self::BASE_URL, self::BODY, [
            'Authorization' => "Bearer $token->plainTextToken",
        ]);
        $content = json_decode($response->getContent(), true);
        $this->assertNotEquals($detail->cart->hash, $content['cartHash']);
        $this->assertEquals($detail->product_id, $content['record']['productId']);
    }
}
