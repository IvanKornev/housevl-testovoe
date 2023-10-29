<?php

namespace App\Modules\Catalog\Filters;

use EloquentFilter\ModelFilter;
use App\Modules\Catalog\Filters\Traits\HasRangeOfValues;

final class ProductFilter extends ModelFilter
{
    use HasRangeOfValues;

    public $relations = [
        'characteristics' => [
            'height', 'widgth', 'length',
        ],
    ];

    /**
     * Фильтр по диапазону цен
     *
     * @param string|array $values (min/max object)
     * @return void
     */
    public function price(string | array $values): void
    {
       $this->filterByRange($values, 'price');
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
