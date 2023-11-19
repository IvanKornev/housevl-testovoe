<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Убирает поле last_used_at из токена
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->dropColumn('last_used_at');
        });
    }

    /**
     * Добавляет поле last_used_at в таблицу токенов
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->timestamp('last_used_at')->nullable();
        });
    }
};
