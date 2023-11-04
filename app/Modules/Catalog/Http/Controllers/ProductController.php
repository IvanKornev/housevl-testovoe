<?php

namespace App\Modules\Catalog\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\{ JsonResponse, Request };

use App\Shared\Transformers\ProductResource;
use App\Modules\Catalog\Http\Requests\ProductsListRequest;
use App\Modules\Catalog\Services\Contracts\IProductService;
use App\Modules\Catalog\Transformers\ProductsListCollection;

class ProductController extends Controller
{
    private IProductService $service;

    public function __construct(IProductService $service)
    {
        $this->service = $service;
    }

    /**
     * Возвращает товар по slug
     * @return JsonResponse
     */
    public function get(Request $request, string $slug): JsonResponse
    {
        $product = new ProductResource($this->service->get($slug));
        return response()->json(['product' => $product]);
    }

    /**
     * Возвращает все товары
     * @return ProductsListCollection
     */
    public function getAll(ProductsListRequest $request): ProductsListCollection
    {
        $products = $this->service->getAll($request->all());
        $results = new ProductsListCollection($products);
        return $results;
    }
}
