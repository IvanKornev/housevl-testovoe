<?php

namespace App\Modules\Catalog\Database\factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Catalog\Entities\Product;

class ProductFactory extends Factory
{
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
        $productName = fake()->words(3, true);
        return [
            'name' => $productName,
            'slug' => Str::slug($productName),
            'image' => fake()->imageUrl(),
            'seo_title' => $productName,
            'seo_description' => fake()->sentence(8),
            'description' => fake()->sentence(12),
            'price' => fake()->randomNumber(6),
        ];
    }
}

