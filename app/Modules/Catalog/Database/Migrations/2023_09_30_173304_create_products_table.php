<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Добавляет таблицу товаров (без лишних отношений)
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('image');
            $table->text('description');
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Убирает таблицу товаров
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
