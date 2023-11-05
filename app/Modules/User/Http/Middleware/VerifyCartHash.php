<?php

declare(strict_types=1);

namespace App\Modules\User\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Modules\User\Entities\Cart;
use Closure;

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
            $content = ['message' => 'Для данной операции хеш корзины обязателен'];
            return response($content, 500);
        }
        $hash = $request->header('Cart-Hash');
        $foundCart = Cart::where('hash', $hash)->first();
        if (!$foundCart) {
            $content = ['message' => 'Был передан некорректный хеш корзины'];
            return response($content, 500);
        }
        return $next($request);
    }
}
