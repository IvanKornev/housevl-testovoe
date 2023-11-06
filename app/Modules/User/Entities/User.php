<?php

namespace App\Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Modules\User\Database\Factories\UserFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory, HasApiTokens;

    protected $hidden = ['password'];
    protected $fillable = [];

    /**
     * Возвращает фабрику пользователя
     *
     * @return Factory
    */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    /**
     * Возвращает корзину пользователя
     *
     * @return HasOne
    */
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }
}
