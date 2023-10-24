<?php

namespace App\Modules\Catalog\Repositories\Contracts;

interface IProductFilterRepository
{
    /**
     * Получаем min/max значения всех фильтров,
     * которые есть в каталоге товаров
     *
     * @return object
     */
    public function getRangeValues(array $rangeFields = []): object;
}
