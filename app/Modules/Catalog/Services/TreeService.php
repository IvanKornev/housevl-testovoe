<?php

namespace App\Modules\Catalog\Services;

use App\Modules\Catalog\Services\Contracts\ITreeService;
use App\Modules\Catalog\Entities\Category;

final class TreeService implements ITreeService
{
    public function get(): array
    {
        $results = Category::all();
        return $results->toArray();
    }
}
