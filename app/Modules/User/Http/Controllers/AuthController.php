<?php

namespace App\Modules\User\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

use App\Modules\User\Http\Requests\RegistrationRequest;

class AuthController extends Controller
{

    /**
     * Регистрирует нового пользователя
     * @return JsonResponse
     */
    public function register(RegistrationRequest $request): JsonResponse
    {
        return response()->json([
            'message' => 'Пользователь успешно зарегистрирован',
        ]);
    }
}
