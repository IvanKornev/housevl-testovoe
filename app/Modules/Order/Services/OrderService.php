<?php

declare(strict_types=1);

namespace App\Modules\Order\Services;

use App\Modules\Order\Services\Contracts\IOrderService;
use App\Modules\Order\DTO\CreateOrderDTO;

final class OrderService implements IOrderService
{
    public function create(CreateOrderDTO $data): string
    {
        return 'some-url.com';
    }
}
