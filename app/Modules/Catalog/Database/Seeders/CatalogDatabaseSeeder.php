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
        $creatingProducts = Product::factory()
            ->count(5)
            ->hasCharacteristics();
        Category::factory()->count(15)->has($creatingProducts)->create();
    }
}
