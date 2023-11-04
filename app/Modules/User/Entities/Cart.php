<?php

namespace App\Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Modules\User\Database\Factories\CartFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [];

    /**
     * Возвращает фабрику корзины
     *
     * @return Factory
    */
    protected static function newFactory(): Factory
    {
        return CartFactory::new();
    }

    /**
     * Возвращает все детали корзины
     *
     * @return HasMany
    */
    public function details(): HasMany
    {
        return $this->hasMany(CartDetail::class);
    }
}
