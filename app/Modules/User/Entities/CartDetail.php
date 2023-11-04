<?php

namespace App\Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Modules\User\Database\Factories\CartDetailFactory;
use App\Modules\User\Events\CartDetailCreating;

class CartDetail extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dispatchesEvents = [
        'creating' => CartDetailCreating::class,
    ];

    protected static function booted(): void
    {
        $totalPriceCallback = function (self $model) {

        };
        static::creating($totalPriceCallback);
    }

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
     * @return HasOne
    */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }

    /**
     * Возвращает корзину, к которой относится
     *
     * @return HasOne
    */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
}
