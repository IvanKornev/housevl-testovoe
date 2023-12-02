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
            'user.fullName' => 'required',
            'user.email' => 'required|email',
            'user.phone' => 'required|phone',
        ];
    }
}
