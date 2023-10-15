<?php

namespace App\Modules\Catalog\Services\Contracts;

use App\Modules\Catalog\Entities\Product;

interface IProductService
{
    /**
     * Получает товар по slug
     * @return Product
     */
    public function get(string $slug): Product;
}
