<?php

namespace App\Modules\Catalog\Filters;

use EloquentFilter\ModelFilter;

class ProductFilter extends ModelFilter
{
    /**
     * Фильтр по диапазону цен
     *
     * @param array $price (min/max object)
     * @return void
     */
    public function price(array $price): void
    {
        ['min' => $min, 'max' => $max] = $price;
        $this->whereBetween('price', [$min, $max]);
    }

    /**
     * Фильтр по slug родительской/дочерней категории
     *
     * @param string $slug
     * @return void
     */
    public function category(string $slug): void
    {
        $this->related('category', 'slug', $slug);
    }
}
