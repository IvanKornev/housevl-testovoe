<?php

namespace App\Shared\Transformers\Product;

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
        return $this->resource->valuesWithUnits;
    }
}
