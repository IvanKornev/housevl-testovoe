<?php

namespace App\Modules\User\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Shared\Transformers\ProductResource;

class CartDetailResource extends JsonResource
{
    /**
     * Преобразует ресурс сущности или коллекции в массив
     *
     * @param Request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $product = new ProductResource($this->product);
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'productId' => $this->product_id,
            'totalPrice' => $this->total_price,
            'updatedAt' => $this->updated_at,
            'createdAt' => $this->created_at,
            'product' => $product,
        ];
    }
}
