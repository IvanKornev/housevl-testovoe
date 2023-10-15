<?php

namespace App\Modules\Catalog\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Modules\Catalog\Services\Contracts\IProductCharacteristicService;
use App\Modules\Catalog\Entities\ProductCharacteristic;

final class ProductCharacteristicService implements IProductCharacteristicService
{
    public function update(array $values, int $id): ProductCharacteristic
    {
        $foundCharacteristics = ProductCharacteristic::find($id)->first();
        if (!$foundCharacteristics) {
            throw new NotFoundHttpException('Характеристики не найдены');
        }
        $foundCharacteristics->update($values);
        return $foundCharacteristics;
    }
}
