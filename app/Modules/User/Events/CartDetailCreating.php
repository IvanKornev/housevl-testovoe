<?php

namespace App\Modules\User\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

use App\Modules\User\Entities\CartDetail;
use App\Modules\User\Entities\Product;

class CartDetailCreating
{
    use SerializesModels;

    /**
     * Новый инстанс события сущности
     *
     * @return void
     */
    public function __construct(CartDetail $model)
    {
        $this->setTotalPrice($model);
    }

     /**
     * Высчитывает итоговую цену во время создания
     * записи
     *
     * @return void
    */
    private function setTotalPrice(CartDetail $model): void
    {
        $relatedProduct = Product::find($model->product_id);
        $model->total_price = $relatedProduct->price * $model->quantity;
    }
}
