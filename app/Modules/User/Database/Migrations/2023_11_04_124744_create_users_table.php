<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
Взаимодействовать с корзиной и оформлять заказы могут как авторизованные, так и неавторизованные пользователи. Заказы должны
содержать контактную информацию покупателя (например email и телефон), а
также список купленных товаров. Для авторизированных пользователей контактная информация должна подтягиваться из профиля автоматически.
*/

return new class extends Migration
{
    /**
     * Создает таблицу пользователя
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic');
            $table->string('email');
            $table->string('phone');
            $table->timestamps();
        });
    }

    /**
     * Откатывает миграции
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
