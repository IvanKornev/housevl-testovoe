<?php

namespace App\Modules\Catalog\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Modules\Catalog\Transformers\Product\CategoryResource;
use App\Modules\Catalog\Transformers\Product\CharacteristicResource;

class ProductResource extends JsonResource
{
    /**
     * Преобразует ресурс сущности или коллекции в массив
     *
     * @param Request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $characteristics = $this->whenLoaded('characteristics');
        $category = $this->whenLoaded('category');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image,
            'description' => $this->description,
            'price' => $this->price,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'category' => new CategoryResource($category),
            'characteristics' => new CharacteristicResource($characteristics),
        ];
    }
}
