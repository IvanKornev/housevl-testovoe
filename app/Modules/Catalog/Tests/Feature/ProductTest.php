<?php

namespace App\Modules\Catalog\Tests\Unit;

use App\Modules\Catalog\Database\Seeders\SingleProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Catalog\Entities\Product;
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
        $this->seed(SingleProductSeeder::class);
        $createdProduct = Product::first();
        $productUrl = str_replace('{slug}', $createdProduct['slug'], static::URL);
        $response = $this->json('GET', $productUrl);
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('product', $content);
        $this->assertIsArray($content['product']['category']);
        $this->assertIsArray($content['product']['characteristics']);
    }

    /**
     * Проверяет статус-код 404 при несуществующем товаре
     *
     * @return void
     */
    public function testReturnsNotFoundError(): void
    {
        $productUrl = str_replace('{slug}', 'unknown', static::URL);
        $response = $this->json('GET', $productUrl);
        $response->assertStatus(404);
    }
}
