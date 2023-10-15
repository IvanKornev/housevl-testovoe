<?php

namespace App\Modules\Catalog\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Modules\Catalog\Services\Contracts\IProductService;
use App\Modules\Catalog\Entities\Product;

final class ProductService implements IProductService
{
    public function get(string $slug): Product
    {
        $product = Product::where('slug', $slug)
            ->with('category.parent')
            ->with('characteristics')
            ->first();
        if (!$product) {
            throw new NotFoundHttpException('Товар не найден');
        }
        return $product;
    }

    public function getAll(): LengthAwarePaginator
    {
        $allProducts = Product::paginate(10);
        return $allProducts;
    }
}
