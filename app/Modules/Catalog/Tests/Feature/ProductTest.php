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
    public const URL = '/api/products';

    /**
     * Проверяет получение товара по slug
     *
     * @return void
     */
    public function testReturnsProductBySlug(): void
    {
        $this->seed(SingleProductSeeder::class);
        $createdProduct = Product::first();
        $productUrl = static::URL . '/' . $createdProduct['slug'];
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
        $productUrl = static::URL . '/' . 'unknown';
        $response = $this->json('GET', $productUrl);
        $response->assertStatus(404);
    }

    /**
     * Проверяет получение всех товаров
     *
     * @return void
     */
    public function testReturnsAllProducts(): void
    {
        $this->seed(SingleProductSeeder::class);
        $response = $this->json('GET', static::URL);
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);
    }

    /**
     * Проверяет корректность и наличие
     * доступных фильтров для каталога
     *
     * @return void
     */
    public function testReturnsAvailableFilters(): void
    {
        $response = $this->json('GET', static::URL);
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('filters', $content);
        foreach ($content['filters'] as $filter) {
            $this->assertArrayHasKey('min', $filter);
            $this->assertArrayHasKey('max', $filter);
        }
    }
}
