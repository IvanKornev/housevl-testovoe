<?php

namespace App\Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Shared\Http\Traits\HasJsonRequestError;

final class RegistrationRequest extends FormRequest
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
            'name' => 'required|string|max:300',
            'password' => 'required|string|max:300',
            'surname' => 'required|string|max:300',
            'patronymic' => 'required|string|max:300',
            'email' => 'required|email|max:300',
            'phone' => 'phone',
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
}
