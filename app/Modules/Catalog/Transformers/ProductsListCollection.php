<?php

namespace App\Modules\Catalog\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Modules\Catalog\Transformers\Product\FilterResource;
use App\Modules\Catalog\Repositories\Contracts\IProductFilterRepository;

class ProductsListCollection extends ResourceCollection
{
    private IProductFilterRepository $productFilter;

    public function __construct(LengthAwarePaginator $resource) {
        parent::__construct($resource);
        $this->resource = $resource;
        $this->productFilter = app(IProductFilterRepository::class);
    }

    /**
     * Преобразует ресурс коллекции в массив
     *
     * @param Request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $filters = $this->productFilter->getRangeValues();
        return [
            'data' => ProductResource::collection($this->collection),
            'filters' => new FilterResource($filters),
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
}
