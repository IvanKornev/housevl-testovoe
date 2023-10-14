<?php

namespace App\Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Modules\Catalog\Database\Factories\CategoryFactory;
use App\Modules\Catalog\Events\CategorySaving;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $dispatchesEvents = [
        'saving' => CategorySaving::class,
    ];

    /**
     * Возвращает фабрику категории
     *
     * @return Factory
    */
    protected static function newFactory(): Factory
    {
        return CategoryFactory::new();
    }

    /**
     * Возвращает все продукты категории
     *
     * @return HasMany
    */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Возвращает родительскую категории
     *
     * @return BelongsTo
    */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Возвращает дочерние категории
     *
     * @return HasMany
    */
    public function childCategories(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
