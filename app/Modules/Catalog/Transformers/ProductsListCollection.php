<?php

namespace App\Modules\Catalog\Transformers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Modules\Catalog\Transformers\Product\FilterResource;

class ProductsListCollection extends ResourceCollection
{
    /**
     * Преобразует ресурс коллекции в массив
     *
     * @param Request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => ProductResource::collection($this->collection),
            'filters' => new FilterResource($this->getFiltersValues()),
        ];
    }

    /**
     * Изменяются метаданные пагинации
     *
     * @param Request  $request
     * @param array $paginated
     * @param array $default
     * @return array
     */
    public function paginationInformation(
        Request $req,
        array $paginated,
        array $default
    ): array {
        $default['meta'] = [
            'pagination' => [
                'currentPage' => $default['meta']['current_page'],
                'total' => $default['meta']['total'],
                'lastPage' => $default['meta']['last_page'],
                'from' => $default['meta']['from'],
            ]
        ];
        return $default;
    }

    private function getFiltersValues(): object
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
