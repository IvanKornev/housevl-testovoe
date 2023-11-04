<?php

namespace App\Modules\User\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

final class AddToCartRequest extends FormRequest
{
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

    /**
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json($validator->errors(), 422);
        throw new HttpResponseException($response);
    }
}
