<?php

namespace App\Modules\User\Services;

use App\Modules\User\Services\Contracts\ICartService;
use App\Modules\User\Repositories\Contracts\ICartRepository;

use App\Modules\User\DTO\CartEditDTO;
use App\Modules\User\DTO\AddToCartDTO;
use App\Modules\User\DTO\RemoveFromCartDTO;

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
        $foundCart = $this->repository->findOrCreate($operationData);
        if (!$foundCart) {
            throw new Exception('Запрошенной корзины не существует');
        }
        $record = $this->repository->store($operationData, $foundCart);
        return $record;
    }

    public function update(CartEditDTO $operationData): CartDetail
    {
        $record = $this->repository->getDetail($operationData);
        $record->quantity = $operationData->quantity;
        $record->save();
        return $record;
    }

    public function getAll(string $cartHash): array
    {
        $cart = $this->repository->get($cartHash);
        $totalPrice = 0;
        if ($cart && $cart->details) {
            $totalPrice = $cart->details->sum('total_price');
        }
        return [
            'items' => $cart->details ?? [],
            'totalPrice' => $totalPrice,
        ];
    }

    public function remove(RemoveFromCartDTO $operationData): array
    {
        $record = $this->repository->getDetail($operationData);
        $record->delete();
        $cartIsEmpty = count($record->cart->details) < 1;
        $cartWasRemoved = false;
        if ($cartIsEmpty) {
            $cartWasRemoved = $record->cart->delete();
        }
        $cartHash = $cartWasRemoved ? null : $record->cart->hash;
        return [$record, $cartHash];
    }
}
