<?php

namespace App\Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Shared\Http\Traits\HasJsonRequestError;

final class LoginRequest extends FormRequest
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
            'email' => 'required|email|max:300',
            'password' => 'required|string|max:300',
        ];
    }
}
