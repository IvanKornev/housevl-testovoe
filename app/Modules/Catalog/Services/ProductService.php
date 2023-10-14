<?php

namespace App\Modules\Catalog\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Modules\Catalog\Services\Contracts\IProductService;
use App\Modules\Catalog\Entities\Product;

final class ProductService implements IProductService
{
    public function get(string $slug): Product
    {
        $product = Product::where('slug', $slug)
            ->with('category')
            ->with('characteristics')
            ->first();
        if (!$product) {
            throw new ModelNotFoundException;
        }
        return $product;
    }
}
