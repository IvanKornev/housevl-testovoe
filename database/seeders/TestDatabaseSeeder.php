<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Modules\Catalog\Database\Seeders\SingleProductSeeder;
use App\Modules\User\Database\Seeders\SingleUserSeeder;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Запускает все сидеры внутри модулей для тестов
     */
    public function run(): void
    {
        $this->call([
            SingleProductSeeder::class,
            SingleUserSeeder::class,
        ]);
    }
}
