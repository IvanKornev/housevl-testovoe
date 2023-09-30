<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Создает таблицу категорий
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('parent_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->string('image');
            $table->string('seo_title');
            $table->string('seo_description');
            $table->timestamps();
        });
    }

    /**
     * Удаляет таблицу категорий
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
