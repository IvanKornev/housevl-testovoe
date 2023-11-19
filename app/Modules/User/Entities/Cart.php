<?php

namespace App\Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

use App\Modules\User\Database\Factories\CartFactory;
use App\Modules\User\Events\CartCreating;

final class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];
    protected $dispatchesEvents = [
        'creating' => CartCreating::class,
    ];


    /**
     * Автогенерирует ULID как хеш корзины
     *
     * @return void
    */
    protected static function booted(): void
    {
        $ulidGenerationCallback = function (self $model) {
            $model->hash = Str::ulid()->toBase32();
        };
        static::creating($ulidGenerationCallback);
    }

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
