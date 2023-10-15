<?php

namespace App\Modules\Catalog\Filters;

use EloquentFilter\ModelFilter;

class ProductFilter extends ModelFilter
{
    public function slug($value)
    {
        return $this->whereLike('slug', "%$value%");
    }
}
