<?php

declare(strict_types=1);

namespace App\Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Shared\Http\Traits\HasJsonRequestError;

final class CreateOrderRequest extends FormRequest
{
    use HasJsonRequestError;

    /**
     * Правила валидации для
     * неавторизованного пользователя
     *
     * @var array
     */
    private const GUEST_RULES = [
        'user.name' => 'required',
        'user.surname' => 'required',
        'user.patronymic' => 'required',
        'user.email' => 'required|email',
        'user.phone' => 'required|phone',
    ];

    /**
     * Валидационые правила по отношению к запросу
     * на подтверждение заказа
     *
     * @return array
     */
    public function rules(): array
    {
        $results = [];
        $currentUser = auth('sanctum')->user();
        if (!$currentUser) {
            $results = static::GUEST_RULES;
        }
        return $results;
    }
}
