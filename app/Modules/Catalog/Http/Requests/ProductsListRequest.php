<?php

namespace App\Modules\Catalog\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

use App\Modules\Catalog\Enums\ProductCharacteristicEnum;

final class ProductsListRequest extends FormRequest
{
    /**
     * Правило для любых полей диапазона
     *
     * @var string
     */
    private const RANGE_RULE = 'numeric|integer|gte:0';

    /**
     * Валидационые правила по отношению к запросу
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = ['category' => 'string'];
        $fields = [...ProductCharacteristicEnum::cases(), 'price'];
        foreach($fields as $field) {
            $fieldName = strtolower($field->name ?? $field);
            $rules["$fieldName.min"] = self::RANGE_RULE;
            $rules["$fieldName.max"] = self::RANGE_RULE;
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
