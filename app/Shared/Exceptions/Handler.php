<?php

declare(strict_types=1);

namespace App\Shared\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Exception;

class Handler extends ExceptionHandler
{
    /**
     * Регистрация обработчика ошибок
     *
     * @return void
     */
    public function register(): void
    {
        $this->renderable(function (Exception $e, $req) {
            if (!$req->is('api/*')) {
                return;
            }
            $fallbackMessage = 'Запись не найдена';
            $message = $e->getMessage() ?? $fallbackMessage;
            $code = $e->getCode();
            $code = $code !== 0 ? $code : 404;
            return response()->json(['message' => $message], $code);
        });
    }
}
