<?php

namespace App\Modules\Catalog\Repositories;

use Illuminate\Support\Facades\DB;
use App\Modules\Catalog\Repositories\Contracts\IProductFilterRepository;

final class ProductFilterRepository implements IProductFilterRepository
{
    public function getRangeValues(): object
    {
        $maxAggregations = [
            DB::raw('MAX(price) as price'),
            DB::raw('MAX(weight) as weight'),
            DB::raw('MAX(height) as height'),
            DB::raw('MAX(width) as width'),
            DB::raw('MAX(length) as length'),
        ];
        $table = 'products';
        $joiningTable = 'product_characteristics';
        $filters = DB::table($table)
            ->join($joiningTable, "$table.id", '=', "$joiningTable.product_id")
            ->select($maxAggregations)
            ->first();
        return $filters;
    }
}
