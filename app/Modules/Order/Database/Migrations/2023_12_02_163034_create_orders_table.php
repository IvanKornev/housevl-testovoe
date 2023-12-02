<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Возможные статусы заказа
     *
     * @var array
     */
    private const STATUSES = [
        'pending',
        'waiting_for_capture',
        'succeeded',
        'canceled',
    ];

    /**
     * Запускает миграции
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->unique();
            $table->enum('status', self::STATUSES)->default('pending');
            $table->boolean('paid')->default(false);
            $table->float('sum');
            $table->string('currency')->default('RUB');
            $table->string('payment_url')->unique();
            $table->string('description')->nullable();
            $table->timestamp('paid_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
