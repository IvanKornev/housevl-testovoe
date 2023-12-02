<?php

declare(strict_types=1);

namespace App\Modules\Order\DTO;

use Spatie\LaravelData\Data;
use Illuminate\Http\Request;

use App\Modules\Order\DTO\Nesting\UserContactDTO;

final class CreateOrderDTO extends Data
{
    public function __construct(
        public UserContactDTO $user,
        public string $cartHash,
    ) {}

    /**
      *Возвращает инстанс DTO из объекта запроса
      * @return self
     */
    public static function fromRequest(Request $request): self
    {
        $body = $request->validated();
        $user = UserContactDTO::fromInput($body['user']);
        $cartHash = $request->header('Cart-Hash');
        return new self($user, $cartHash);
    }
}