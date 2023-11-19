<?php

namespace App\Modules\User\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\User\Http\Requests\RegistrationRequest;
use App\Modules\User\Http\Requests\LoginRequest;
use App\Modules\User\Services\Contracts\IAuthService;

use App\Modules\User\DTO\LoginDTO;
use App\Modules\User\DTO\RegistrationDTO;

final class AuthController extends Controller
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
            'message' => 'Регистрация прошла успешно',
            'record' => $createdUser,
        ]);
    }

    /**
     * Авторизует пользователя
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $formData = LoginDTO::from($request->validated());
        $authorizedUser = $this->service->login($formData);
        $token = $authorizedUser->createToken('api');
        return response()->json([
            'message' => 'Вход был успешно осуществлен',
            'token' => $token->plainTextToken,
            'cartHash' => $authorizedUser->cart->hash ?? null,
        ]);
    }

    /**
     * Выход из аккаунта путем удаления API-токена
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $wasDeleted = $request->user()->currentAccessToken()->delete();
        $body = [
            'status' => $wasDeleted ? 'success' : 'error',
            'message' => 'Вы успешно вышли из аккаунта',
        ];
        if (!$wasDeleted) {
            $body['message'] = 'При выходе из аккаунта произошла ошибка';
        }
        return response()->json($body);
    }
}
