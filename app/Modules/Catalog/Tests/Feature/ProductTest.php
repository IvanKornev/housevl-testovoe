<?php

namespace App\Modules\Catalog\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Catalog\Entities\{ Product, Category };
use Tests\TestCase;

final class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * URL вызываемого эндпоинта
     *
     * @var string
     */
    public const URL = '/api/products/{slug}';

    /**
     * Проверяет получение товара по slug
     *
     * @return void
     */
    public function testReturnsProductBySlug(): void
    {
        $parentCategory = Category::factory()->create();
        $categoryCallback = fn () => ['category_id' => $parentCategory->id];
        $createdProduct = Product::factory()->state($categoryCallback)->create();
        $productUrl = str_replace('{slug}', $createdProduct->slug, static::URL);
        $response = $this->json('GET', $productUrl);
        $response->assertStatus(200);
    }
}
