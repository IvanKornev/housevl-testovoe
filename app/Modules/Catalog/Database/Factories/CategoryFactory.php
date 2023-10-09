<?php

namespace App\Modules\Catalog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Catalog\Database\Factories\Traits\HasCategoryFields;
use App\Modules\Catalog\Entities\Category;

class CategoryFactory extends Factory
{
    use HasCategoryFields;

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
        return $this->getCategoryFields();
    }
}

