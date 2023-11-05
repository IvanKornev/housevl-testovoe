<?php

namespace App\Modules\User\Services;

use App\Modules\User\Services\Contracts\ICartService;
use App\Modules\User\DTO\AddToCartDTO;
use App\Modules\User\Entities\Cart;
use App\Modules\User\Entities\CartDetail;
use App\Modules\User\Repositories\Contracts\ICartRepository;
use Exception;

final class CartService implements ICartService
{
    /**
     * Сообщение о некорректной корзине
     *
     * @var string
     */
    private const INVALID_CART_MESSAGE = 'Запрошенной в запросе корзины не '
        . 'существует или она была удалена';

    private ICartRepository $repository;

    public function __construct(ICartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(AddToCartDTO $operationData): CartDetail
    {
        $createdCart = null;
        if ($operationData->cartHash === null) {
            $createdCart = Cart::create();
            $operationData->cartHash = $createdCart->hash;
        }
        $searchQuery = Cart::query()->where('hash', $operationData->cartHash);
        $foundCart = $createdCart ?? $searchQuery->first();
        if (!$foundCart) {
            throw new Exception(self::INVALID_CART_MESSAGE);
        }
        $record = $this->repository->store($operationData, $foundCart);
        return $record;
    }

    public function update(AddToCartDTO $operationData): CartDetail
    {
        $foundCart = Cart::where('hash', $operationData->cartHash)->first();
        $details = CartDetail::query()
            ->where('cart_id', $foundCart->id)
            ->where('product_id', $operationData->productId)
            ->firstOrFail();
        $details->quantity = $operationData->quantity;
        $details->save();
        return $details;
    }
}
