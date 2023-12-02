<?php

declare(strict_types=1);

namespace App\Modules\Order\Services;

use Illuminate\Support\Facades\DB;
use Exception;

use App\Modules\Order\Services\Contracts\IOrderService;
use App\Modules\Order\Integrations\Contracts\IOrderPaymentRequest;
use App\Modules\Order\Adapters\CartAdapter;
use App\Modules\Order\Entities\Order;
use App\Modules\Order\DTO\CreateOrderDTO;

final class OrderService implements IOrderService
{
    private IOrderPaymentRequest $paymentRequest;
    private CartAdapter $cartAdapter;

    /**
     * Ошибка пустой внутри корзины
     *
     * @var string
     */
    private const EMPTY_CART_MESSAGE = 'Заказ не может '
        . 'быть создан для пустой корзины';

    public function __construct(
        IOrderPaymentRequest $paymentRequest,
        CartAdapter $cartAdapter,
    ) {
        $this->paymentRequest = $paymentRequest;
        $this->cartAdapter = $cartAdapter;
    }

    public function create(CreateOrderDTO $data): string
    {
        $withItemsInside = count($data->cart->details) > 0;
        if (!$withItemsInside) {
            throw new Exception(static::EMPTY_CART_MESSAGE);
        }
        $createCallback = function () use ($data) {
            $paymentValues = $this->paymentRequest->query($data);
            $createdOrder = Order::create($paymentValues);
            $this->cartAdapter->delete($data->cart->id);
            return $createdOrder;
        };
        $createdOrder = DB::transaction($createCallback);
        return $createdOrder->payment_url;
    }
}
