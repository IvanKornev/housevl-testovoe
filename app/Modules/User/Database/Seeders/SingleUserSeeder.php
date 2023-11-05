<?php

namespace App\Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;

use App\Modules\User\Entities\User;
use App\Modules\User\Entities\Cart;

class SingleUserSeeder extends Seeder
{
    /**
     * Добавляет в систему одного пользователя (для тестов)
     * @return void
     */
    public function run(): void
    {
        $cartsWithDetails = Cart::factory()->hasDetails();
        User::factory()->has($cartsWithDetails)->create();
    }
}
