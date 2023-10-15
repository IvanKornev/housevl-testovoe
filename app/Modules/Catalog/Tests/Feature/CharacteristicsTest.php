<?php

namespace App\Modules\Catalog\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CharacteristicsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * URL вызываемого эндпоинта
     *
     * @var string
     */
    public const URL = '/api/products/characterics/{id}';

    /**
     * Проверяет статус-код 404 при несуществующих характеристиках
     *
     * @return void
     */
    public function testReturnsNotFoundError(): void
    {
        $concreteUrl = str_replace('{id}', 'unknown', static::URL);
        $response = $this->json('GET', $concreteUrl);
        $response->assertStatus(404);
    }
}
