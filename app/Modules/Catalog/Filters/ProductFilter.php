<?php

namespace App\Modules\Catalog\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\Catalog\Repositories\Contracts\IProductFilterRepository;

final class ProductFilter extends ModelFilter
{
    private IProductFilterRepository $repository;

    public function __construct(Builder $builder, array $input)
    {
        parent::__construct($builder, $input);
        $this->repository = app(IProductFilterRepository::class);
    }

    /**
     * Фильтр по значению высоты
     *
     * @param array $value (min/max object)
     * @return void
     */
    public function height(string | array $value): void
    {
        if (gettype($value) !== 'array') {
            return;
        }
        $max = $value['max'] ?? false;
        if (!$max) {
            $maxFallback = $this->repository
                ->getRangeValues(['height'])
                ->height;
            $max = $maxFallback;
        }
        $min = $value['min'] ?? 0;
        $this->related('characteristics', function ($query) use ($min, $max) {
            $rangeValues = [(int) $min, (int) $max];
            $query->whereBetween('height', $rangeValues);
        });
    }

    /**
     * Фильтр по диапазону цен
     *
     * @param array $price (min/max object)
     * @return void
     */
    public function price(string | array $price): void
    {
        if (gettype($price) !== 'array') {
            return;
        }
        $max = $price['max'] ?? false;
        if (!$max) {
            $maxFallback = $this->repository
                ->getRangeValues(['price'])
                ->price;
            $max = $maxFallback;
        }
        $min = $price['min'] ?? 0;
        $rangeValues = [(int) $min, (int) $max];
        $this->whereBetween('price', $rangeValues);
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
