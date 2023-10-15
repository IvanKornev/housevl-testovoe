<?php

namespace App\Modules\Catalog\Services\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Modules\Catalog\Entities\Product;

interface IProductService
{
    /**
     * Получает товар по slug
     * @return Product
     */
    public function get(string $slug): Product;
    /**
     * Получает все товары
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator;
}
