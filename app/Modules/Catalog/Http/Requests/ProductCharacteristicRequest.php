<?php

namespace App\Modules\Catalog\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ProductCharacteristicRequest extends FormRequest
{
    /**
     * Валидационые правила по отношению к запросу
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];
        $allowedFields = ['length', 'weight', 'width', 'height'];
        foreach ($allowedFields as $fieldName) {
            $rules[$fieldName] = 'integer|numeric|nullable';
            $unitField = "{$fieldName}_unit";
            $rules[$unitField] = "required_with:$fieldName|string|nullable";
        }
        return $rules;
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
