<?php

namespace App\Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Modules\User\Database\Seeders\UserDatabaseSeeder;

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
     * Проверяет добавление первого товара в анонимную корзину
     *
     * @return void
     */
    public function testAddsFirstItemToAnonymousCart(): void
    {
        $response = $this->json('POST', self::BASE_URL, [
            'productId' => 1,
        ]);
        $response->assertStatus(200);
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
}
