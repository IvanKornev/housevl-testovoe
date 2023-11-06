<?php

namespace App\Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

use App\Modules\User\Http\Requests\RegistrationRequest;
use App\Modules\User\Services\Contracts\IAuthService;
use App\Modules\User\DTO\RegistrationDTO;

class AuthController extends Controller
{
    private IAuthService $service;

    public function __construct(IAuthService $service)
    {
        $this->service = $service;
    }

    /**
     * Регистрирует нового пользователя
     * @return JsonResponse
     */
    public function register(RegistrationRequest $request): JsonResponse
    {
        $formData = RegistrationDTO::from($request->validated());
        $createdUser = $this->service->register($formData);
        return response()->json([
            'message' => 'Пользователь успешно зарегистрирован',
            'record' => $createdUser,
        ]);
    }

    /**
     * Авторизует пользователя
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        return response()->json(['message' => 'OK']);
    }
}
