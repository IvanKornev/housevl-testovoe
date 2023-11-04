<?php

namespace App\Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Modules\User\Database\Factories\CartDetailFactory;

class CartDetail extends Model
{
    use HasFactory;

    protected $fillable = [];

    /**
     * Возвращает фабрику деталей конкретной корзины
     *
     * @return Factory
    */
    protected static function newFactory(): Factory
    {
        return CartDetailFactory::new();
    }
}
