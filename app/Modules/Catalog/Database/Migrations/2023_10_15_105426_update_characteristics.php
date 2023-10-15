<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Обновляет таблицу характеристик через миграцию
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('product_characteristics', function (Blueprint $table) {
            $table->string('weight')->change();
            $table->string('length')->change();
            $table->string('width')->change();
            $table->string('height')->change();
        });
    }

    /**
     * Откатывает миграцию
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_characteristics', function (Blueprint $table) {
            $table->integer('weight')->change();
            $table->integer('length')->change();
            $table->integer('width')->change();
            $table->integer('height')->change();
        });
    }
};
