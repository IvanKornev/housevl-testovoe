<?php

namespace App\Modules\Catalog\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\{ JsonResponse, Request };

use App\Modules\Catalog\Services\Contracts\IProductCharacteristicService;
use App\Modules\Catalog\Transformers\Product\CharacteristicResource;

class ProductCharacteristicController extends Controller
{
    private IProductCharacteristicService $service;

    public function __construct(IProductCharacteristicService $service)
    {
        $this->service = $service;
    }

    /**
     * Обновляет характеристики товара по ID
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $values = $request->input();
        $charateristics = $this->service->update($values, $id);
        return response()->json([
            'message' => 'Товар успешно обновлен',
            'characteristics' => new CharacteristicResource($charateristics),
        ]);
    }
}
