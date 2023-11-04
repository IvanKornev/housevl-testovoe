<?php

namespace App\Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\User\Entities\User;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Заполняет хранилище данными модуля
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->count(20)->create();
    }
}
