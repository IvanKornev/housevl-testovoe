<?php

declare(strict_types=1);

namespace App\Modules\Order\Adapters;

use App\Modules\User\Api\Contracts\ICartApi;

final class CartAdapter
{
    private readonly ICartApi $api;

    public function __construct(ICartApi $api)
    {
        $this->api = $api;
    }

    /**
     * Получает корзину по её ID
     *
     * @param int $id
     * @return array
     */
    public function get(int $id): array
    {
        $results = $this->api->get($id);
        return $results;
    }

    /**
     * Получает корзину по её хешу
     *
     * @param string $hash
     * @return array
     */
    public function getByHash(string $hash): array
    {
        $results = $this->api->getByHash($hash);
        return $results;
    }

    /**
     * Удаляет корзину по её ID
     *
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        $results = $this->api->delete($id);
        return $results;
    }

    /**
     * Добавляет новую корзину
     *
     * @return array
     */
    public function add(): array
    {
        $results = $this->api->add();
        return $results;
    }
}
