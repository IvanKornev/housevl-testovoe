<?php

namespace App\Modules\Catalog\Database\Seeders;

use App\Modules\Catalog\Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;
use App\Modules\Catalog\Entities\Category;
use App\Modules\Catalog\Entities\Product;

class CatalogDatabaseSeeder extends Seeder
{
    /**
     * Заполняет каталог магазина фейковыми данными
     *
     * @return void
     */
    public function run(): void
    {
        $products = Product::factory()->count(5)->hasCharacteristics();
        $parentCategories = Category::factory()->count(5)->create();
        foreach ($parentCategories as $parent) {
            Category::factory()
                ->count(3)
                ->has($products)
                ->state(function () use ($parent) {
                    return ['parent_id' => $parent->id];
                })
                ->create();
        }
    }
}
