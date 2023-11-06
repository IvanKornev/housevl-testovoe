<?php

namespace App\Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Modules\User\Database\Factories\CartDetailFactory;
use App\Modules\User\Events\CartDetailChanges;

class CartDetail extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dispatchesEvents = [
        'creating' => CartDetailChanges::class,
        'updating' => CartDetailChanges::class,
    ];

    /**
     * Возвращает фабрику деталей конкретной корзины
     *
     * @return Factory
    */
    protected static function newFactory(): Factory
    {
        return CartDetailFactory::new();
    }

    /**
     * Возвращает продукт, связанный с записью в корзине
     *
     * @return BelongsTo
    */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Возвращает корзину, к которой относится
     *
     * @return BelongsTo
    */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
}
