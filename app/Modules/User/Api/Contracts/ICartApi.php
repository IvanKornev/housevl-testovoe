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
     * Находит корзину по её уникальному хешу
     *
     * @param string $hash
     * @return array
    */
    public function getByHash(string $hash): array;
    /**
     * Удаляет корзину по её ID
     *
     * @param int $id
     * @return int
    */
    public function delete(int $id): int;
    /**
     * Добавляет анонимную корзину
     *
     * @return array
    */
    public function add(): array;
}
