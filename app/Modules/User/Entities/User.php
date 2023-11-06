<?php

namespace App\Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;

use App\Modules\User\Database\Factories\UserFactory;
use App\Modules\User\Events\UserChanges;

class User extends Model
{
    use HasFactory, HasApiTokens;

    protected $dispatchesEvents = [
        'creating' => UserChanges::class,
        'updating' => UserChanges::class,
    ];
    protected $hidden = ['password'];
    protected $guarded = [];

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
