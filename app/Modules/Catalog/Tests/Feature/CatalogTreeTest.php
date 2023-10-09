<?php

namespace App\Modules\Catalog\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class CatalogTreeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * URL вызываемого эндпоинта
     *
     * @var string
     */
    public const URL = '/api/catalog/tree';

    /**
     * Проверяет получение дерева категорий
     *
     * @return void
     */
    public function testReturnsTheCatalogTree(): void
    {
        $response = $this->json('GET', self::URL);
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $this->assertTrue(array_is_list($content['categories']));
    }
}
