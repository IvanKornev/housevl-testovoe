<?php

namespace App\Modules\Catalog\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\{ JsonResponse, Request };
use App\Modules\Catalog\Services\Contracts\IProductService;

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
        $product = $this->service->get($slug);
        return response()->json(['product' => $product]);
    }
}
