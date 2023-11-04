<?php

namespace App\Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Modules\User\Database\Factories\CartDetailFactory;

class CartDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Высчитывает итоговую цену во время создания
     * записи
     *
     * @return void
    */
    protected static function booted(): void
    {
        $totalPriceCallback = function (self $model) {
            $relatedProduct = Product::find($model->product_id);
            $model->total_price = $relatedProduct->price * $model->quantity;
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
}
