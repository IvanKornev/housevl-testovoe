<?php

namespace App\Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Catalog\Entities\Category;
use App\Modules\Catalog\Entities\Product;

class SingleProductSeeder extends Seeder
{
    /**
     * Добавляет в каталог один товар (для тестов)
     *
     * @return void
    */
    public function run(): void
    {
        $parentCategory = Category::factory()->create()->toArray();
        Product::factory()
            ->hasCharacteristics()
            ->state(fn () => ['category_id' => $parentCategory['id']])
            ->create()
            ->toArray();
    }
}
