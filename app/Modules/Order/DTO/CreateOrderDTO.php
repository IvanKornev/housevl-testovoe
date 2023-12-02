<?php

declare(strict_types=1);

namespace App\Modules\Order\DTO;

use Spatie\LaravelData\Data;
use Illuminate\Http\Request;

use App\Modules\Order\DTO\Nesting\UserContactDTO;
use App\Modules\Order\DTO\Nesting\CartDTO;
use App\Modules\Order\Adapters\CartAdapter;

final class CreateOrderDTO extends Data
{
    public function __construct(
        public UserContactDTO $user,
        public CartDTO $cart,
    ) {}

    /**
      *Возвращает инстанс DTO из объекта запроса
      *
      * @param Request $request
      * @return self
     */
    public static function fromRequest(Request $request): self
    {
        $body = $request->validated();
        $user = UserContactDTO::from($body['user']);
        $cartAdapter = app(CartAdapter::class);
        $hash = $request->header('Cart-Hash');
        $cart = CartDTO::from($cartAdapter->getByHash($hash));
        return new self($user, $cart);
    }
}
