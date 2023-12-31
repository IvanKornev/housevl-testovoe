<?php

namespace App\Modules\Catalog\Database\Factories\Traits;

trait HasCategoryFields
{
  /**
    * Возвращает поля, являющиеся общими для товаров,
    * категорий и пр. сущностей
    *
    * @return array
  */
  protected function getCategoryFields(): array
  {
    $name = fake()->words(3, true);
    return [
        'name' => $name,
        'image' => fake()->imageUrl(),
        'seo_title' => $name,
        'seo_description' => fake()->sentence(8),
    ];
  }
}
