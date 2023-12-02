<?php

declare(strict_types=1);

namespace App\Modules\Order\Integrations\Contracts;

use App\Modules\Order\DTO\CreateOrderDTO;

interface IOrderPaymentRequest
{
    /**
     * Возвращает URL для оплаты заказа
     *
     * @param CreateOrderDTO;
     * @return string (URL для оплаты заказа)
    */
    public function query(CreateOrderDTO $data): string;
}
