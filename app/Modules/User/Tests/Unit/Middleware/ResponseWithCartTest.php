<?php

declare(strict_types=1);

namespace App\Modules\User\Tests\Unit\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

use App\Modules\User\Http\Middleware\ResponseWithCart;
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
}
