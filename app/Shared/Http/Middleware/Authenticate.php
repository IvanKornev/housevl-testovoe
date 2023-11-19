<?php

declare(strict_types=1);

namespace App\Shared\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    /**
     * Обработка случая, при котором пользователь не авторизован
    */
    protected function unauthenticated($request, array $guards): void
    {
        throw new AuthenticationException('Вы не авторизованы', $guards);
    }

}
