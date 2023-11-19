<?php

namespace App\Modules\Catalog\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Shared\Tests\TestCase;

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
    private const URL = '/api/products/characteristics/{id}';

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
        $newValues = ProductCharacteristic::factory()->make();
        $response = $this->json('PATCH', $concreteUrl, $newValues->toArray());
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('characteristics', $content);
        $expectedValues = $newValues->valuesWithUnits;
        foreach ($content['characteristics'] as $name => $value) {
            $this->assertEquals($expectedValues[$name], $value);
        }
    }

    /**
     * Проверяет валидацию параметра в url
     *
     * @return void
     */
    public function testChecksRouteParam(): void
    {
        $concreteUrl = str_replace('{id}', 'string', static::URL);
        $response = $this->json('PATCH', $concreteUrl);
        $response->assertStatus(404);
    }

    /**
     * Проверяет валидацию тела запроса
     *
     * @return void
     */
    public function testChecksBodyValidation(): void
    {
        $newValues = ['length' => true];
        $concreteUrl = str_replace('{id}', '1', static::URL);
        $response = $this->json('PATCH', $concreteUrl, $newValues);
        $response->assertStatus(422);
        $content = json_decode($response->getContent(), true);
        $expectedMessage = 'Поле "длина" должно быть числом';
        $this->assertEquals($expectedMessage, $content['length'][0]);
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
