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
            $changeChildState = function (array $child) use ($parent) {
                $slug = "{$parent->slug}/{$child['slug']}";
                $result = ['parent_id' => $parent->id, 'slug' => $slug];
                return $result;
            };
            Category::factory()
                ->count(3)
                ->has($products)
                ->state($changeChildState)
                ->create();
        }
    }
}
