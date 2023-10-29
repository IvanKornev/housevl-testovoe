<?php

namespace App\Modules\Catalog\Transformers\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilterResource extends JsonResource
{
    /**
     * Преобразует полученные фильтры в объект, удобный
     * для работы на клиенте
     *
     * @param Request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $results = [];
        $allFilters = (array) $this->resource;
        foreach ($allFilters as $name => $value) {
            $results[$name] = ['min' => 0, 'max' => (int) $value];
        }
        return $results;
    }
}
