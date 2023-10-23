<?php

namespace App\Modules\Catalog\Transformers\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacteristicResource extends JsonResource
{
    /**
     * Преобразует ресурс сущности или коллекции в массив
     *
     * @param Request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $results = [];
        $possibleFields = ['weight', 'length', 'width', 'height'];
        foreach ($possibleFields as $field) {
            $value = $this->resource[$field];
            $unitField = "{$field}_unit";
            $unit = $this->resource[$unitField];
            $results[$field] = "$value $unit";
        }
        return $results;
    }
}
