<?php

namespace App\Modules\Catalog\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ProductsListRequest extends FormRequest
{
    /**
     * Валидационые правила по отношению к запросу
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'category' => 'string',
            'price.min' => 'numeric|integer|gte:0',
            'price.max' => 'numeric|integer|gte:0',
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
