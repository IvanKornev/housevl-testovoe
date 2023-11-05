<?php

namespace App\Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Modules\User\Entities\Cart;

class CartFactory extends Factory
{
    /**
     *
     * @var string
    */
    protected $model = Cart::class;

    /**
     * Возвращает корзину, созданную через фабрику
     *
     * @return array
    */
    public function definition(): array
    {
        return ['hash' => Str::ulid()->toBase32()];
    }
}
