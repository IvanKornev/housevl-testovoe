<?php

namespace App\Modules\Catalog\Services\Contracts;

use App\Modules\Catalog\Entities\ProductCharacteristic;

interface IProductCharacteristicService
{
    /**
     * Обновляет характеристики товара по ID
     * @return ProductCharacteristic
     */
    public function update(array $values, int $id): ProductCharacteristic;
}
