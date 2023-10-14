<?php

namespace App\Modules\Catalog\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TreeResource extends JsonResource
{
    /**
     * Resource для дерева каталога
     *
     * @param Request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image,
            'createdAt' => $this->created_at,
            "updatedAt" => $this->updated_at,
            'children' => static::collection($this->whenLoaded('childCategories')),
        ];
    }
}
