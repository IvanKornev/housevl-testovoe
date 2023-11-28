<?php

declare(strict_types=1);

namespace App\Modules\User\Tests\Unit\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

use App\Modules\User\Tests\Unit\Middleware\Traits\HandleCartHash;
use App\Modules\User\Http\Middleware\ResponseWithCart;
use App\Modules\User\Entities\Cart;
use App\Shared\Tests\TestCase;

final class ResponseWithCartTest extends TestCase
{
    use RefreshDatabase, HandleCartHash;

    private ResponseWithCart $middleware;
    private Request $request;

    /**
     * Запускает тесты, а также инжектирует
     * инстансы промежуточного ПО и класса запроса
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->middleware = app(ResponseWithCart::class);
        $this->request = new Request;
        $this->artisan('db:seed --class=TestDatabaseSeeder');
    }

    /**
     * Проверяет возврат пустого объекта корзины
     * для отсутствующего хеша
     *
     * @return void
     */
    public function testReturnsEmptyCartForUndefinedHash(): void
    {
        $returnedCart = $this->handleResponseWithCart();
        $this->assertIsArray($returnedCart['items']);
        $this->assertCount(0, $returnedCart['items']);
        $this->assertEquals(0, $returnedCart['totalPrice']);
    }

    /**
     * Проверяет возврат объекта корзины
     * для хеша из хедера запроса
     *
     * @return void
     */
    public function testReturnsCartForHashFromHeader(): void
    {
        $foundCart = Cart::inRandomOrder()->limit(1)->first();
        $this->request->headers->set('Cart-Hash', $foundCart->hash);
        $returnedCart = $this->handleResponseWithCart();
        $this->assertCount(1, $returnedCart['items']);
        $cartItem = $returnedCart['items'][0];
        $this->assertEquals($returnedCart['totalPrice'], $cartItem['totalPrice']);
    }

    /**
     * Проверяет возврат объекта корзины
     * для хеша из тела ответа
     *
     * @return void
     */
    public function testReturnsCartForHashFromResponseBody(): void
    {
        $foundCart = Cart::inRandomOrder()->limit(1)->first();
        $responseFields = ['cartHash' => $foundCart->hash];
        $returnedCart = $this->handleResponseWithCart($responseFields);
        $this->assertCount(1, $returnedCart['items']);
    }
}
