<?php

declare(strict_types=1);

namespace App\Modules\User\Tests\Unit\Middleware\Traits;

use Illuminate\Http\JsonResponse;

trait HandleCartHash
{
    /**
     * Обрабатывает хеш корзины с ошибкой
     *
     * @param string $message
     * @return void
     */
    private function handleRequestWithError(string $message): void
    {
        $response = $this->middleware->handle($this->request, function () {});
        $this->assertEquals(500, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $this->assertEquals($message, $content['message']);
    }

    /**
     * Обрабатывает и дополняет JSON-ответ
     * ассоц.массивом корзины
     *
     * @param string $hash
     * @return array (ассоц. массив корзины)
     */
    private function handleResponseWithCart(string $hash = ''): array
    {
        if ($hash) {
            $this->request->headers->set('Cart-Hash', $hash);
        }
        $nextCallback = fn (): JsonResponse => response()->json([
            'message' => 'is ok',
        ]);
        $res = $this->middleware->handle($this->request, $nextCallback);
        $cart = json_decode($res->getContent(), true)['meta']['cart'];
        return $cart;
    }
}
