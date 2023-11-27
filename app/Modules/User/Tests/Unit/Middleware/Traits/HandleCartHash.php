<?php

declare(strict_types=1);

namespace App\Modules\User\Tests\Unit\Middleware\Traits;

trait HandleCartHash
{
    /**
     * Обрабатывает хеш корзины с ошибкой
     *
     * @param string $message
     * @return void
     */
    private function handleWithError(string $message): void
    {
        $response = $this->middleware->handle($this->request, function () {});
        $this->assertEquals(500, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $this->assertEquals($message, $content['message']);
    }
}
