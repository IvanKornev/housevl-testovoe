<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Catalog\Database\Seeders\CatalogDatabaseSeeder;
use App\Modules\User\Database\Seeders\UserDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Запускает все сидеры внутри модулей
     */
    public function run(): void
    {
        $this->call([
            CatalogDatabaseSeeder::class,
            UserDatabaseSeeder::class,
        ]);
    }
}
