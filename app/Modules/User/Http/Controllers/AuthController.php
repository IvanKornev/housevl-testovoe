<?php

namespace App\Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{

    /**
     * Регистрирует нового пользователя
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Пользователь успешно зарегистрирован',
        ]);
    }
}
