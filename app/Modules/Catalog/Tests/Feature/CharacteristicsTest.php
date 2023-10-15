<?php

namespace App\Modules\Catalog\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Modules\Catalog\Database\Seeders\SingleProductSeeder;
use App\Modules\Catalog\Entities\ProductCharacteristic;

final class CharacteristicsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * URL вызываемого эндпоинта
     *
     * @var string
     */
    public const URL = '/api/products/characteristics/{id}';

    /**
     * Тест, успешно обновляющий характеристики товара
     *
     * @return void
     */
    public function testUpdatesCharacteristics(): void
    {
        $this->seed(SingleProductSeeder::class);
        $id = ProductCharacteristic::first()->id;
        $concreteUrl = str_replace('{id}', $id, static::URL);
        $response = $this->json('PATCH', $concreteUrl);
        $response->assertStatus(200);
    }

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
