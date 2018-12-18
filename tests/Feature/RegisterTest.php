<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**@test*/
    public function testsRegistersSuccessfully()
    {
        $payload = [
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ];

        $this->json('post', '/api/auth/register', $payload)
                ->assertStatus(200)
                ->assertJsonStructure([
                    'access_token',
                    'expires_in',
                    'token_type',
                    'user',
        ]);
    }

    public function testsRequiresPasswordEmailAndName()
    {
        $this->json('post', '/api/auth/register')
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => [ "The name field is required."],
                    "email" => ["The email field is required."],
                    "password_confirmation" => ["The password confirmation field is required."]
                ],
            ]);
    }

    public function testsRequirePasswordConfirmation()
    {
        $payload = [
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => '123456',
        ];

        $this->json('post', '/api/auth/register', $payload)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "password" => ["The password and password confirmation must match."],
                    "password_confirmation" => ["The password confirmation field is required."]
                ]
            ]);
    }
}
