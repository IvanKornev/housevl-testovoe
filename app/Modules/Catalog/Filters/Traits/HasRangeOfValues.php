<?php

namespace App\Modules\Catalog\Filters\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Modules\Catalog\Repositories\Contracts\IProductFilterRepository;

trait HasRangeOfValues
{
    private IProductFilterRepository $repository;

    public function __construct(Builder $builder, array $input)
    {
        parent::__construct($builder, $input);
        $this->repository = app(IProductFilterRepository::class);
    }

    /**
     * Фильтрует поле по минимальному/максимальному диапазону
     *
     * @param array $values (min/max object)
     * @param string $field
     *
     * @return void
    */
    private function filterByRange(mixed $values, string $field): void
    {
        if (gettype($values) !== 'array') {
            return;
        }
        $max = $values['max'] ?? false;
        if (!$max) {
            $fallbackValues = (array) $this->repository->getRangeValues([$field]);
            $maxFallback = $fallbackValues[$field];
            $max = $maxFallback;
        }
        $min = $values['min'] ?? 0;
        $rangeValues = [(int) $min, (int) $max];
        $this->whereBetween($field, $rangeValues);
    }
}
