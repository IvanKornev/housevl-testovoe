<?php

namespace App\Modules\Catalog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Catalog\Entities\ProductCharacteristic;
use App\Modules\Catalog\Enums\ProductCharacteristicEnum;

class ProductCharacteristicFactory extends Factory
{
    /**
     *
     * @var string
     */
    protected $model = ProductCharacteristic::class;

    /**
     * Заполняет характеристики товара
     *
     * @return array
    */
    public function definition(): array
    {
        $filledFields = [];
        foreach (ProductCharacteristicEnum::cases() as $value) {
            $generatedNumber = fake()->randomNumber(nbDigits: 2, strict: true);
            $fieldName = strtolower($value->name);
            $filledFields[$fieldName] = $generatedNumber;
            $unitField = "{$fieldName}_unit";
            $unitValue = $fieldName === 'weight' ? 'кг.' : 'см.';
            $filledFields[$unitField] = $unitValue;
        }
        return $filledFields;
    }
}

