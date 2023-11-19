<?php

declare(strict_types=1);

namespace App\Shared\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Exception;

class Authenticate extends Middleware
{
    /**
     * Обработка случая, при котором пользователь не авторизован
    */
    protected function unauthenticated($request, array $guards): void
    {
        throw new Exception('Вы не авторизованы', 401);
    }

}
