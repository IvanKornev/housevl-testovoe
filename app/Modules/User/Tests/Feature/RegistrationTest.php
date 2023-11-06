<?php

namespace App\Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\User\Entities\User;
use Tests\TestCase;

final class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * URL вызываемого эндпоинта
     *
     * @var string
     */
    private const URL = '/api/auth/registration';

    public function testRegistersUserInTheSystem(): void
    {
        $userForm = User::factory()->make()->toArray();
        $response = $this->json('POST', self::URL, $userForm);
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $this->assertIsArray($content['record']);
    }

    public function testFailsRequestValidation(): void
    {
        $userForm = ['name' => false];
        $response = $this->json('POST', self::URL, $userForm);
        $response->assertStatus(422);
    }
}
