<?php

declare(strict_types=1);

namespace App\Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\User\Services\Contracts\ICartService;

final class ResponseWithCart
{
    private ICartService $cartService;

    public function __construct(ICartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $isJsonResponse = $response instanceof JsonResponse;
        if(!$isJsonResponse){
            return $response;
        }
        $currentData = json_decode(json_encode($response->getData()), true);
        $cartHash = $request->header('Cart-Hash') ?? '';
        $currentData['meta']['cart'] = $this->cartService->getAll($cartHash);
        $response->setData($currentData);
        return $response;
    }
}
