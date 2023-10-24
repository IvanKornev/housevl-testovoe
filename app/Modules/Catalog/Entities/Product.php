<?php

namespace App\Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use EloquentFilter\Filterable;

use App\Modules\Catalog\Database\Factories\ProductFactory;
use App\Modules\Catalog\Filters\ProductFilter;

class Product extends Model
{
    use HasFactory, Filterable;

    protected $casts = ['price' => 'integer'];
    protected $fillable = [];

    /**
     * Автогенерирует slug для товара
     *
     * @return void
    */
    protected static function booted(): void
    {
        $slugGenerationCallback = function (self $model) {
            $model->slug = Str::slug($model->name);
        };
        static::creating($slugGenerationCallback);
    }

    /**
     * Возвращает название класса-фильтра
     *
     * @return string
    */
    public function modelFilter(): string
    {
        return $this->provideFilter(ProductFilter::class);
    }

    /**
     * Возвращает фабрику товара
     *
     * @return Factory
    */
    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }

    /**
     * Возвращает родительскую категорию
     *
     * @return BelongsTo
    */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Возвращает характеристики товара
     *
     * @return HasOne
    */
    public function characteristics(): HasOne
    {
        return $this->hasOne(ProductCharacteristic::class);
    }
}
