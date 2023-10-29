<?php

namespace App\Modules\Catalog\Filters;

use EloquentFilter\ModelFilter;
use App\Modules\Catalog\Filters\Traits\HasRangeOfValues;

final class ProductCharacteristicFilter extends ModelFilter
{
    use HasRangeOfValues;

    /**
     * Фильтр по значениям высоты
     *
     * @param string|array $values (min/max object)
     * @return void
     */
    public function height(string | array $values): void
    {
        $this->filterByRange($values, 'height');
    }

    /**
     * Фильтр по значениям ширины
     *
     * @param string|array $values (min/max object)
     * @return void
     */
    public function width(string | array $values): void
    {
        $this->filterByRange($values, 'width');
    }

    /**
     * Фильтр по значениям длины
     *
     * @param string|array $values (min/max object)
     * @return void
     */
    public function length(string | array $values): void
    {
        $this->filterByRange($values, 'length');
    }
}
