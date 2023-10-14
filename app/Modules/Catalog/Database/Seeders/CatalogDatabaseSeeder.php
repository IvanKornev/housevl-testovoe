<?php

namespace App\Modules\Catalog\Database\Seeders;

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
        $products = Product::factory()->count(25)->hasCharacteristics();
        $parentCategories = Category::factory()->count(5)->create();
        foreach ($parentCategories as $parent) {
            $setParentCategory = function () use ($parent) {
                return ['parent_id' => $parent->id];
            };
            Category::factory()
                ->count(8)
                ->has($products)
                ->state($setParentCategory)
                ->create();
        }
    }
}
