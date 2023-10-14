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
        $parentCategory = Category::factory()->create()->toArray();
        $createdProduct = Product::factory()
            ->hasCharacteristics()
            ->state(fn () => ['category_id' => $parentCategory['id']])
            ->create()
            ->toArray();
        $productUrl = str_replace('{slug}', $createdProduct['slug'], static::URL);
        $response = $this->json('GET', $productUrl);
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('product', $content);
        $this->assertIsArray($content['product']['category']);
        $this->assertIsArray($content['product']['characteristics']);
    }
}
