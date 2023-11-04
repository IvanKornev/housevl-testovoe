<?php

namespace App\Modules\Catalog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Modules\Catalog\Enums\ProductCharacteristicEnum;
use App\Shared\Http\Traits\HasJsonRequestError;

class ProductCharacteristicRequest extends FormRequest
{
    use HasJsonRequestError;

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
}
