<?php

namespace App\Modules\Catalog\Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Catalog\Entities\Category;

class CategoryFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Category::class;

    /**
     * Наполнение полей категорий
     *
     * @return array
     */
    public function definition(): array
    {
        $categoryName = fake()->words(3, true);
        return [
            'name' => $categoryName,
            'slug' => Str::slug($categoryName),
            'image' => fake()->imageUrl(),
            'seo_title' => $categoryName,
            'seo_description' => fake()->sentence(8),
        ];
    }
}

