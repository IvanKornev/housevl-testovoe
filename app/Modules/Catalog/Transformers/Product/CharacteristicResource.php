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
            $results[$field] = $this[$field];
            $unitField = "{$field}_unit";
            $results[$unitField] = $this[$unitField];
        }
        return $results;
    }
}
