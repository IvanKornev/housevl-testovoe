<?php

namespace App\Modules\Catalog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Catalog\Database\Factories\Traits\HasCategoryFields;
use App\Modules\Catalog\Entities\Product;

class ProductFactory extends Factory
{
    use HasCategoryFields;

    /**
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Заполняет товары каталога
     *
     * @return array
     */
    public function definition(): array
    {
        $categoryFields = $this->getCategoryFields();
        return [
            ...$categoryFields,
            'description' => fake()->sentence(12),
            'price' => fake()->randomNumber(6),
        ];
    }
}

