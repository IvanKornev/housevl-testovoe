<?php

declare(strict_types=1);

namespace App\Modules\Order\Services;

use App\Modules\Order\Services\Contracts\IOrderService;
use App\Modules\Order\Adapters\CartAdapter;
use App\Modules\Order\DTO\CreateOrderDTO;

final class OrderService implements IOrderService
{
    private CartAdapter $adapter;

    public function __construct(CartAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function create(CreateOrderDTO $data): string
    {
        $this->adapter->delete($data->cartHash);
        return 'some-url.com';
    }
}
