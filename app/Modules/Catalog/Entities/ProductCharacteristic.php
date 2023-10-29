<?php

namespace App\Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use EloquentFilter\Filterable;

use App\Modules\Catalog\Database\Factories\ProductCharacteristicFactory;
use App\Modules\Catalog\Filters\ProductCharacteristicFilter;
use App\Modules\Catalog\Enums\ProductCharacteristicEnum;

class ProductCharacteristic extends Model
{
    use HasFactory, Filterable;

    protected $guarded = ['id', 'product_id'];
    public $timestamps = false;

    /**
     * Возвращает фабрику характеристик товара
     *
     * @return Factory
    */
    protected static function newFactory(): Factory
    {
        return ProductCharacteristicFactory::new();
    }

    /**
     * Возвращает название класса-фильтра
     *
     * @return string
    */
    protected function modelFilter(): string
    {
        return $this->provideFilter(ProductCharacteristicFilter::class);
    }

    /**
     * Получает значения, объединенные с их единицами
     * измерения
     *
     */
    protected function valuesWithUnits(): Attribute
    {
        $getterCallback = function (mixed $value, array $attrs): array {
            $results = [];
            foreach (ProductCharacteristicEnum::cases() as $value) {
                $fieldName = strtolower($value->name);
                $value = $attrs[$fieldName];
                $unitField = "{$fieldName}_unit";
                $unit = $attrs[$unitField];
                $results[$fieldName] = "$value $unit";
            }
            return $results;
        };
        return Attribute::make($getterCallback);
    }
}
