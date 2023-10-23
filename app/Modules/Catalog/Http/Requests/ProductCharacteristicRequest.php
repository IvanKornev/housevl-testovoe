<?php

namespace App\Modules\Catalog\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Catalog\Enums\ProductCharacteristicEnum;

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
        foreach (ProductCharacteristicEnum::cases() as $value) {
            $fieldName = strtolower($value->name);
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
