<?php

namespace App\Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\User\Entities\CartDetail;
use App\Modules\User\Entities\Product;

class CartDetailFactory extends Factory
{
    /**
     *
     * @var string
    */
    protected $model = CartDetail::class;

    /**
     * Возвращает детали корзины, созданные через фабрику
     *
     * @return array
    */
    public function definition(): array
    {
        $addedProduct = Product::inRandomOrder()->limit(1)->first();
        $quantity = $this->faker->numberBetween(1, 5);
        return [
            'product_id' => $addedProduct->id,
            'quantity' => $quantity,
            'total_price' => $quantity * $addedProduct->price,
        ];
    }
}
