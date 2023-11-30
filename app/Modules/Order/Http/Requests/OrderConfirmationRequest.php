<?php

namespace App\Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Shared\Http\Traits\HasJsonRequestError;

class OrderConfirmationRequest extends FormRequest
{
    use HasJsonRequestError;

    /**
     * Валидационые правила по отношению к запросу
     * на подтверждение заказа
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user.fullname' => 'required',
            'user.email' => 'required|email',
            'user.phone' => 'required|phone',
        ];
    }

    /**
     * Имеет ли авториз. пользователь право сделать этот запрос
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
