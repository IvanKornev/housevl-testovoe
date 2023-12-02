<?php

declare(strict_types=1);

namespace App\Modules\Order\Services;

use App\Modules\Order\Services\Contracts\IOrderService;
use App\Modules\Order\Adapters\CartAdapter;
use App\Modules\Order\DTO\CreateOrderDTO;
use Exception;

final class OrderService implements IOrderService
{
    private CartAdapter $adapter;

    /**
     * Ошибка пустой внутри корзины
     *
     * @var string
     */
    private const EMPTY_CART_MESSAGE = 'Заказ не может '
        . 'быть создан для пустой корзины';

    public function __construct(CartAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function create(CreateOrderDTO $data): string
    {
        $foundCart = $this->adapter->getByHash($data->cartHash);
        $withItemsInside = count($foundCart['details']) > 0;
        if (!$withItemsInside) {
            throw new Exception(static::EMPTY_CART_MESSAGE);
        }
        $this->adapter->delete($foundCart['id']);
        return 'some-url.com';
    }
}
