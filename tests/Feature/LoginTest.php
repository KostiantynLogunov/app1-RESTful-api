<?php

namespace Tests\Feature\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**@test*/
    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/auth/login')
            ->assertStatus(401)
            ->assertJson([
                "error" => "Unauthorized"
            ]);
    }


        public function testUserLoginsSuccessfully()
        {
            $user = factory(User::class)->create([
                'name' => 'test',
                'email' => 'test@test.com',
                'password' => bcrypt('123456'),
            ]);

            $payload = ['email' => 'test@test.com', 'password' => '123456'];

            $this->json('POST', 'api/auth/login', $payload)
                ->assertStatus(200)
                ->assertJsonStructure([
                        'access_token',
                        'expires_in',
                        'token_type',
                        'user',
                ]);

        }
}
