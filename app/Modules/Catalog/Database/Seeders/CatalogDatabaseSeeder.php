<?php

namespace App\Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Catalog\Entities\Category;

class CatalogDatabaseSeeder extends Seeder
{
    /**
     * Заполняет каталог магазина фейковыми данными
     *
     * @return void
     */
    public function run(): void
    {
        Category::factory()
            ->hasProducts(10)
            ->count(20)
            ->create();
    }
}
