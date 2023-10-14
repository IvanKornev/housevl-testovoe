<?php

namespace App\Modules\Catalog\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    /**
     * Возвращает товар по slug
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        return response()->json(['message' => 'ok']);
    }
}
