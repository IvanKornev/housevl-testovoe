<?php

namespace App\Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;

use App\Modules\User\Entities\User;
use App\Modules\User\Entities\Cart;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Заполняет хранилище данными модуля
     *
     * @return void
     */
    public function run(): void
    {
        $cartsWithDetails = Cart::factory()->hasDetails();
        $cartsWithDetails->count(5)->create();
        User::factory()
            ->has($cartsWithDetails)
            ->count(20)
            ->create();
    }
}
