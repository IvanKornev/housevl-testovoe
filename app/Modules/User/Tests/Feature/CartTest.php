<?php

namespace App\Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Modules\User\Database\Seeders\UserDatabaseSeeder;

final class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * URL вызываемого эндпоинта
     *
     * @var string
     */
    private const URL = '/api/cart/add';

    /**
     * Проверяет добавление первого товара в анонимную корзину
     *
     * @return void
     */
    public function testAddsFirstItemToAnonymousCart(): void
    {
        $response = $this->json('GET', self::URL);
        $response->assertStatus(200);
    }
}
