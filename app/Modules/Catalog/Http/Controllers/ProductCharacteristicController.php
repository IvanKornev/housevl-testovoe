<?php

namespace App\Modules\Catalog\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\{ JsonResponse, Request };


class ProductCharacteristicController extends Controller
{
    /**
     * Обновляет характеристики товара по ID
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        return response()->json(['message' => 'Товар успешно обновлен']);
    }
}
