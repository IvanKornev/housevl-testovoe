<?php

declare(strict_types=1);

namespace App\Modules\User\Tests\Unit\Middleware;

use Illuminate\Http\Request;
use App\Shared\Tests\TestCase;
use App\Modules\User\Http\Middleware\VerifyCartHash;

final class VerifyCartHashTest extends TestCase
{
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
        $nextCallback = function ($req) {};
        $response = $this->middleware->handle($this->request, $nextCallback);
        $this->assertEquals(500, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(self::REQUIRED_MESSAGE, $content['message']);
    }
}
