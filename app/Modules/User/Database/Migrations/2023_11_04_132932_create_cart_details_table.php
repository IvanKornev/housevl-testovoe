<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Создает таблицу деталей корзины
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('cart_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->references('id')->on('carts')->cascadeOnDelete();
            $table->foreignId('product_id')->references('id')->on('products');
            $table->integer('quantity')->default(1);
            $table->decimal('total');
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
        Schema::dropIfExists('cart_details');
    }
};
