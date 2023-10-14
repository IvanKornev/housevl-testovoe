<?php

namespace App\Modules\Catalog\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface ITreeService
{
    /**
     * Возвращает родительские категории вместе с дочерними
     * @return Collection
     */
    public function get(): Collection;
}
