<?php

declare(strict_types=1);

namespace App\Modules\User\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Closure, Exception;

class VerifyCartHash
{
    /**
     * Проверяем наличие корректного хеша корзины в одном
     * из хедеров
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasHeader('Cart-Hash')) {
            throw new Exception('Для данной операции хеш корзины обязателен');
        }
        return $next($request);
    }
}
