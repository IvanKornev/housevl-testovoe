<?php

declare(strict_types=1);

namespace App\Modules\User\Tests\Unit\Middleware;

use Illuminate\Http\Request;
use App\Shared\Tests\TestCase;
use App\Modules\User\Http\Middleware\VerifyCartHash;

final class VerifyCartHashTest extends TestCase
{
    /**
     * Проверяет возврат ошибки о том,
     * что хеш корзины обязателен
     *
     * @return void
     */
    public function testReturnsAnErrorThatCartHashIsRequired(): void
    {
        $request = new Request;
        $middleware = new VerifyCartHash;
        $nextCallback = function ($req) {};
        $response = $middleware->handle($request, $nextCallback);
        $this->assertEquals(500, $response->getStatusCode());
        $expectedMessage = 'Для данной операции хеш корзины обязателен';
        $content = json_decode($response->getContent(), true);
        $this->assertEquals($expectedMessage, $content['message']);
    }
}
