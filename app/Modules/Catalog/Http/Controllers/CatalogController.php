<?php

namespace App\Modules\Catalog\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CatalogController extends Controller
{
    /**
     * Возвращает дерево каталога со всеми категориями
     * @return JsonResponse
     */
    public function getTree(): JsonResponse
    {
        return response()->json(['message' => 'ok']);
    }
}
