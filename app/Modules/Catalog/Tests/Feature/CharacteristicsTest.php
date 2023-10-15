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
        $newValues = ProductCharacteristic::factory()->make()->toArray();
        $response = $this->json('PATCH', $concreteUrl, $newValues);
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('characteristics', $content);
        foreach ($content['characteristics'] as $name => $value) {
            $this->assertEquals($newValues[$name], $value);
        }
    }

    /**
     * Тест, успешно обновляющий характеристики товара
     *
     * @return void
     */
    public function testChecksBodyValidation(): void
    {
        $newValues = ['length' => true];
        $concreteUrl = str_replace('{id}', '1', static::URL);
        $response = $this->json('PATCH', $concreteUrl, $newValues);
        $response->assertStatus(422);
    }

    /**
     * Проверяет статус-код 404 при несуществующих характеристиках
     *
     * @return void
     */
    public function testReturnsNotFoundError(): void
    {
        $concreteUrl = str_replace('{id}', '565', static::URL);
        $response = $this->json('PATCH', $concreteUrl);
        $response->assertStatus(404);
    }
}
