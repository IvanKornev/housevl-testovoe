<?php

namespace App\Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\User\Entities\Product;
use App\Modules\User\Entities\Cart;
use App\Modules\User\Tests\Feature\Traits\HasAnonymousCart;
use App\Shared\Tests\TestCase;

final class AnonymousCartTest extends TestCase
{
    use RefreshDatabase, HasAnonymousCart;

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
     * Проверяет добавление первого товара в анонимную корзину
     *
     * @return void
     */
    public function testAddsFirstItemToAnonymousCart(): void
    {
        $product = Product::inRandomOrder()->limit(1)->first();
        $response = $this->json('POST', self::BASE_URL, [
            'productId' => $product->id,
        ]);
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $record = $content['record'];
        $this->assertEquals($product->id, $record['product']['id']);
        $expectedCount = 1;
        $this->assertEquals($expectedCount, $record['quantity']);
        $itemsInsideCart = count($content['meta']['cart']['items']);
        $this->assertEquals($expectedCount, $itemsInsideCart);
    }

    /**
     * Проверяет возврат ошибок при некорректных
     * query-параметрах
     *
     * @return void
     */
    public function testAddsItemWithRequestError(): void
    {
        $response = $this->json('POST', self::BASE_URL, [
            'quantity' => 'some-string',
        ]);
        $response->assertStatus(422);
    }

    /**
     * Проверяет то, что при повторном добавлении товара в ту же корзину, вместо
     * добавления ещё одной записи, просто будет изменено поле quantity
     * в уже существующей записи
     *
     * @return void
     */
    public function testIncreasesItemQuantityInsteadOfAddingDuplicate(): void
    {
        $product = Product::inRandomOrder()->limit(1)->first();
        $data = ['productId' => $product->id, 'quantity' => 2];
        $response = $this->json('POST', self::BASE_URL, $data);
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $response = $this->json('POST', self::BASE_URL, $data, [
            'Cart-Hash' => $content['cartHash'],
        ]);
        $newContent = json_decode($response->getContent(), true);
        $correctQuantity = 4;
        $this->assertEquals($correctQuantity, $newContent['record']['quantity']);
        $this->assertEquals($content['record']['id'], $newContent['record']['id']);
    }

    /**
     * Проверяет изменение количества товара, добавленного
     * в корзину
     *
     * @return void
     */
    public function testEditsProductQuantityInTheCart(): void
    {
        $detail = $this->getDetailFromAnonymousCart();
        $url = self::BASE_URL . "/{$detail->id}";
        $quantity = fake()->randomNumber(1, 10);
        $data = ['quantity' => $quantity];
        $headers = ['Cart-Hash' => $detail->cart->hash];
        $response = $this->json('PATCH', $url, $data, $headers);
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $this->assertEquals($content['record']['quantity'], $quantity);
    }

    /**
     * Проверяет наличие ошибки, которая должна вернуться при
     * отсутствующем хеше корзины
     *
     * @return void
     */
    public function testReturnsErrorOnCartHashMissing(): void
    {
        $url = self::BASE_URL . '/1';
        $response = $this->json('PATCH', $url);
        $response->assertStatus(500);
    }

    /**
     * Проверяет наличие ошибки, которая должна вернуться при
     * некорректном хеше корзины
     *
     * @return void
     */
    public function testReturnsErrorOnInvalidCartHash(): void
    {
        $url = self::BASE_URL . '/1';
        $headers = ['Cart-Hash' => 'some-string'];
        $response = $this->json('PATCH', $url, [], $headers);
        $response->assertStatus(500);
    }

    /**
     * Проверяет удаление товара из корзины
     *
     * @return void
     */
    public function testRemovesProductFromCart(): void
    {
        $detail = $this->getDetailFromAnonymousCart();
        $headers = ['Cart-Hash' => $detail->cart->hash];
        $url = self::BASE_URL . "/{$detail->id}";
        $response = $this->json('DELETE', $url, [], $headers);
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $removedCartHash = null;
        $this->assertEquals($content['cartHash'], $removedCartHash);
    }

    /**
     * Проверяет получение полной корзины
     *
     * @return void
     */
    public function testGetsFullCart(): void
    {
        $cart = Cart::inRandomOrder()->limit(1)->first();
        $headers = ['Cart-Hash' => $cart->hash];
        $response = $this->json('GET', self::BASE_URL, [], $headers);
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $this->assertIsArray($content['meta']['cart']['items']);
    }

    /**
     * Проверяет наличие корзины в поле meta в любом из
     * эндпоинтов
     *
     * @return void
     */
    public function testChecksCartExistenceInTheApiMetaObject(): void
    {
        $response = $this->json('GET', '/api/catalog/tree');
        $content = json_decode($response->getContent(), true);
        $this->assertIsArray($content['meta']['cart']['items']);
        $this->assertIsInt($content['meta']['cart']['totalPrice']);
    }
}
