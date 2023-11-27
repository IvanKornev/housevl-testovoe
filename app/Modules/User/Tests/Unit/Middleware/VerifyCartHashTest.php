<?php

declare(strict_types=1);

namespace App\Modules\User\Tests\Unit\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

use App\Modules\User\Http\Middleware\VerifyCartHash;
use App\Shared\Tests\TestCase;

final class VerifyCartHashTest extends TestCase
{
    use RefreshDatabase;

    private VerifyCartHash $middleware;
    private Request $request;

    /**
     * Сообщение об обязательном хеше корзины
     *
     * @var string
     */
    private const REQUIRED_MESSAGE = 'Для данной операции '
        . 'хеш корзины обязателен';

    /**
     * Сообщение об некорректном хеше корзины
     *
     * @var string
     */
    private const INVALID_HASH_MESSAGE = 'Был передан '
        . 'некорректный хеш корзины';

    /**
     * Запускает тесты, а также инжектирует
     * инстансы промежуточного ПО и класса запроса
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->middleware = new VerifyCartHash;
        $this->request = new Request;
    }

    /**
     * Проверяет возврат ошибки о том,
     * что хеш корзины обязателен
     *
     * @return void
     */
    public function testReturnsAnErrorThatCartHashIsRequired(): void
    {
        $response = $this->middleware->handle($this->request, function () {});
        $this->assertEquals(500, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(self::REQUIRED_MESSAGE, $content['message']);
    }

    /**
     * Проверяет возврат ошибки о том,
     * что хеш некорректен
     *
     * @return void
     */
    public function testReturnsAnErrorThatCartHashIsInvalid(): void
    {
        $this->request->headers->set('Cart-Hash', 'incorrect-hash');
        $response = $this->middleware->handle($this->request, function () {});
        $this->assertEquals(500, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(self::INVALID_HASH_MESSAGE, $content['message']);
    }
}
