<?php

declare(strict_types=1);

namespace App\Modules\User\Tests\Unit\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

use App\Modules\User\Http\Middleware\ResponseWithCart;
use App\Modules\User\Entities\Cart;
use App\Shared\Tests\TestCase;

final class ResponseWithCartTest extends TestCase
{
    use RefreshDatabase;

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
        $res = $this->middleware->handle($this->request, function () {
            return response()->json(['message' => 'is ok']);
        });
        $cart = json_decode($res->getContent(), true)['meta']['cart'];
        $this->assertIsArray($cart['items']);
        $this->assertCount(0, $cart['items']);
        $this->assertEquals(0, $cart['totalPrice']);
    }

    /**
     * Проверяет возврат объекта корзины
     * для хеша из хедера запроса
     *
     * @return void
     */
    public function testReturnsCartForHashFromHeader(): void
    {
        $cart = Cart::inRandomOrder()->limit(1)->first();
        $this->request->headers->set('Cart-Hash', $cart->hash);
        $res = $this->middleware->handle($this->request, function () {
            return response()->json(['message' => 'is ok']);
        });
        $cart = json_decode($res->getContent(), true)['meta']['cart'];
        $this->assertCount(1, $cart['items']);
        $cartItem = $cart['items'][0];
        $this->assertEquals($cart['totalPrice'], $cartItem['totalPrice']);
    }
}
