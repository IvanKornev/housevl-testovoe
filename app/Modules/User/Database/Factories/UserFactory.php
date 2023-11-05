<?php

namespace App\Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\User\Entities\User;

class UserFactory extends Factory
{
    /**
     *
     * @var string
    */
    protected $model = User::class;

    /**
     * Возвращает пользователя, созданного через фабрику
     *
     * @return array
    */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'surname' => fake()->word(),
            'patronymic' => fake()->word(),
            'email' => fake()->email(),
            'phone' => fake()->e164PhoneNumber(),
        ];
    }
}
