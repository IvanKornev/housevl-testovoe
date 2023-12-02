<?php

declare(strict_types=1);

namespace App\Modules\Order\Integrations\Contracts;

use App\Modules\Order\DTO\CreateOrderDTO;

interface IOrderPaymentRequest
{
    /**
     * Возвращает данные для оплаты созданного заказа
     *
     * @param CreateOrderDTO;
     * @return array (данные для оплаты заказа)
    */
    public function query(CreateOrderDTO $data): array;
}
