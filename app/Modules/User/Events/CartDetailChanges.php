<?php

namespace App\Modules\User\Events;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Queue\SerializesModels;

use App\Modules\User\Entities\CartDetail;
use App\Modules\User\Entities\Product;

final class CartDetailChanges
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
     * Высчитывает итоговую цену во время создания или обновления
     * записи
     *
     * @return void
    */
    private function setTotalPrice(CartDetail $model): void
    {
        $relatedProduct = Product::find($model->product_id);
        if (!$relatedProduct) {
            throw new NotFoundHttpException('Такой товар не найден');
        }
        $totalPrice = $relatedProduct->price * $model->quantity;
        $model->total_price = $totalPrice;
    }
}
