<?php

declare(strict_types=1);

namespace App\Modules\User\Api\Contracts;

interface ICartApi
{
    /**
     * Возвращает корзину по ID для одного
     * из внутренних модулей системы
     *
     * @param int $id
     * @return array
    */
    public function get(int $id): array;
     /**
     * Удаляет корзину по её уникальному хешу
     *
     * @param string $hash
     * @return int
    */
    public function delete(string $hash): int;
}
