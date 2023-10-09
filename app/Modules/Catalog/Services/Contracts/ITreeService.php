<?php

namespace App\Modules\Catalog\Services\Contracts;

interface ITreeService
{
    /**
     * Возвращает родительские категории вместе с дочерними
     * @return array
     */
    public function get(): array;
}
