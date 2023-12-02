<?php

declare(strict_types=1);

namespace App\Modules\Order\Services\Contracts;

use App\Modules\Order\DTO\CreateOrderDTO;

interface IOrderService
{
    /**
     * Возвращает URL для оплаты заказа
     * @param CreateOrderDTO;
     * @return string (URL для оплаты заказа)
    */
    public function create(CreateOrderDTO $data): string;
}
