<?php

declare(strict_types=1);

namespace App\Shared\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable, Exception;

class Handler extends ExceptionHandler
{
    /**
     * Регистрация обработчика ошибок
     *
     * @return void
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if (!$request->is('api/*')) {
                return;
            }
            $fallbackMessage = 'Запись не найдена';
            $message = $e->getMessage() ?? $fallbackMessage;
            return response()->json(['message' => $message], 404);
        });
    }
}
