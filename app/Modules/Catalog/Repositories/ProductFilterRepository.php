<?php

namespace App\Modules\Catalog\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

use App\Modules\Catalog\Repositories\Contracts\IProductFilterRepository;
use App\Modules\Catalog\Enums\ProductCharacteristicEnum;

final class ProductFilterRepository implements IProductFilterRepository
{
    public function getRangeValues(array $rangeFields = []): object
    {
        if (count($rangeFields) < 1) {
            $rangeFields = $this->getDefaultRangeFields();
        }
        $maxAggregation = Arr::map($rangeFields, function ($field) {
            return DB::raw("MAX($field) as $field");
        });
        $table = 'products';
        $joiningTable = 'product_characteristics';
        $filters = DB::table($table)
            ->join($joiningTable, "$table.id", '=', "$joiningTable.product_id")
            ->select($maxAggregation)
            ->first();
        return $filters;
    }

    private function getDefaultRangeFields(): array
    {
        $characteristics = ProductCharacteristicEnum::cases();
        $characteristics = Arr::map($characteristics, function ($value) {
            return strtolower($value->name);
        });
        $results = ['price', ...$characteristics];
        return $results;
    }
}
