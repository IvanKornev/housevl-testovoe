<?php

namespace App\Modules\Catalog\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Modules\Catalog\Database\Seeders\CatalogDatabaseSeeder;

final class CatalogTreeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * URL вызываемого эндпоинта
     *
     * @var string
     */
    private const URL = '/api/catalog/tree';

    /**
     * Проверяет получение дерева категорий
     *
     * @return void
     */
    public function testReturnsTheCatalogTree(): void
    {
        $this->seed(CatalogDatabaseSeeder::class);
        $response = $this->json('GET', self::URL);
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('categories', $content);
        $this->assertIsList($content['categories']);
        foreach ($content['categories'] as $category) {
            $this->assertArrayHasKey('children', $category);
        }
    }
}
