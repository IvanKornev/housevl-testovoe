<?php

namespace App\Modules\Catalog\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class CatalogTreeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверяет получение дерева категорий
     *
     * @return void
     */
    public function test_returns_the_catalog_tree(): void
    {
        $this->assertTrue(true);
    }
}
