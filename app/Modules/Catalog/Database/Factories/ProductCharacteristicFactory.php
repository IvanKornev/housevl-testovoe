<?php

namespace App\Modules\Catalog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Catalog\Entities\ProductCharacteristic;

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
        $requiredFields = ['weight', 'length', 'width', 'height'];
        foreach ($requiredFields as $fieldName) {
            $generatedNumber = fake()->randomNumber(nbDigits: 2, strict: true);
            $filledFields[$fieldName] = $generatedNumber;
            $unitField = "{$fieldName}_unit";
            $unitValue = $fieldName === 'weight' ? 'кг.' : 'см.';
            $filledFields[$unitField] = $unitValue;
        }
        return $filledFields;
    }
}

