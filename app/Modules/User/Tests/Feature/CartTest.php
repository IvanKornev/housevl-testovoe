<?php

namespace App\Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\User\Entities\Product;
use Tests\TestCase;

final class CartTest extends TestCase
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
        $expectedQuantity = 1;
        $this->assertEquals($expectedQuantity, $record['quantity']);
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
}
