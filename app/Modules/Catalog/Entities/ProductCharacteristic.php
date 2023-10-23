<?php

namespace App\Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

use App\Modules\Catalog\Database\Factories\ProductCharacteristicFactory;

class ProductCharacteristic extends Model
{
    use HasFactory;

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
     * Получает значения, объединенные с их единицами
     * измерения
     *
     */
    protected function valuesWithUnits(): Attribute
    {
        $getterCallback = function (mixed $value, array $attrs): array {
            $fields = ['weight', 'length', 'width', 'height'];
            $results = [];
            foreach ($fields as $fieldName) {
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
