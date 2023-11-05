<?php

namespace App\Modules\User\Services;

use App\Modules\User\Services\Contracts\ICartService;
use App\Modules\User\Repositories\Contracts\ICartRepository;

use App\Modules\User\DTO\CartEditDTO;
use App\Modules\User\DTO\AddToCartDTO;

use App\Modules\User\Entities\Cart;
use App\Modules\User\Entities\CartDetail;
use Exception;

final class CartService implements ICartService
{
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
            throw new Exception('Запрошенной корзины не существует');
        }
        $record = $this->repository->store($operationData, $foundCart);
        return $record;
    }

    public function update(CartEditDTO $operationData): CartDetail
    {
        $details = CartDetail::findOrFail($operationData->cartDetailsId);
        if ($details->cart->hash !== $operationData->cartHash) {
            throw new Exception('Запись не принадлежит этой корзине');
        }
        $details->quantity = $operationData->quantity;
        $details->save();
        return $details;
    }
}
