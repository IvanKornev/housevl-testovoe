<?php

namespace App\Modules\Catalog\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

use App\Modules\Catalog\Services\Contracts\ITreeService;
use App\Modules\Catalog\Transformers\TreeResource;

class TreeController extends Controller
{
    private ITreeService $service;

    public function __construct(ITreeService $service)
    {
        $this->service = $service;
    }

    /**
     * Возвращает дерево каталога со всеми категориями
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        $categories = TreeResource::collection($this->service->get());
        return response()->json(['categories' => $categories]);
    }
}
