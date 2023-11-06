<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Делает поле user_id уникальным
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreignId('user_id')
                ->change()
                ->nullable()
                ->references('id')
                ->on('users')
                ->unique();
        });
    }

    /**
     * Делает поле user_id неуникальным
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreignId('user_id')
                ->change()
                ->nullable()
                ->references('id')
                ->on('users');
        });
    }
};
