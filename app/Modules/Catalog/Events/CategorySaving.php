<?php

namespace App\Modules\Catalog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

use App\Modules\Catalog\Entities\Category;

class CategorySaving
{
    use SerializesModels;

    /**
     * Новый инстанс события сущности
     *
     * @return void
     */
    public function __construct(Category $model)
    {
        $this->autoGenerateSlug($model);
    }

    /**
     * Генерирует slug для
     * дочерней/родительской категории
     *
     * @return void
    */
    private function autoGenerateSlug(Category $model): void
    {
        $slugValue = Str::slug($model->name);
        $isChild = $model->parent_id !== null;
        if ($isChild) {
            $slugValue = "{$model->parent->slug}/{$slugValue}";
        }
        $model->slug = $slugValue;
    }
}
