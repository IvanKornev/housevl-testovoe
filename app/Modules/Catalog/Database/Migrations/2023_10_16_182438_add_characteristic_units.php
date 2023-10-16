<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Добавляет единицы измерения для каждой характеристики
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('product_characteristics', function (Blueprint $table) {
            $table->string('weight_unit')->default('кг.');
            $table->string('length_unit')->default('см.');
            $table->string('width_unit')->default('см.');
            $table->string('height_unit')->default('см.');
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
            $table->dropColumn('weight_unit');
            $table->dropColumn('length_unit');
            $table->dropColumn('width_unit');
            $table->dropColumn('height_unit');
        });
    }
};
