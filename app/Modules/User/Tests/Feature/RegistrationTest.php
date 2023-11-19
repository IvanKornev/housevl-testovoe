<?php

namespace App\Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\User\Entities\User;
use App\Shared\Tests\TestCase;

final class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * URL вызываемого эндпоинта
     *
     * @var string
     */
    private const URL = '/api/auth/registration';

    /**
     * Проверяет фичу регистрации
     *
     * @return void
     */
    public function testRegistersUserInTheSystem(): void
    {
        $userForm = $this->getUserForm();
        $response = $this->json('POST', self::URL, $userForm);
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $this->assertIsArray($content['record']);
    }

    /**
     * Проверяет возврат ошибки при провале валидации
     *
     * @return void
     */
    public function testFailsRequestValidation(): void
    {
        $userForm = ['name' => false];
        $response = $this->json('POST', self::URL, $userForm);
        $response->assertStatus(422);
    }

    /**
     * Проверяет возврат ошибки при дублировании названия почты
     *
     * @return void
     */
    public function testReturnsAnErrorIfEmailIsNotUnique (): void
    {
        $userForm = $this->getUserForm();
        $this->json('POST', self::URL, $userForm);
        $response = $this->json('POST', self::URL, $userForm);
        $response->assertStatus(500);
        $content = json_decode($response->getContent(), true);
        $expectedMessage = 'Пользователь с такой почтой существует';
        $this->assertEquals($content['message'], $expectedMessage);
    }

    /**
     * Возвращает содержимое формы пользователя
     *
     * @return array
     */
    private function getUserForm(): array
    {
        $results = User::factory()->make()
            ->makeVisible(['password'])
            ->toArray();
        return $results;
    }
}
