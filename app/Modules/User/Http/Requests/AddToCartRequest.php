<?php

namespace App\Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Shared\Http\Traits\HasJsonRequestError;

final class AddToCartRequest extends FormRequest
{
    use HasJsonRequestError;

    /**
     * Валидационые правила по отношению к запросу
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'quantity' => 'numeric|integer|gte:0',
            'productId' => 'required|numeric|integer|gte:0',
        ];
    }
}
