<?php

declare(strict_types=1);

namespace App\Modules\Cart\Api\Contracts;

interface ICartApi
{
    /**
     * Возвращает корзину по ID для одного
     * из внутренних модулей системы
     *
     * @return array
    */
    public function get(int $id): array;
}
