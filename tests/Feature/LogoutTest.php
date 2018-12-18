<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     * $credentials = request(['email', 'password']);

    if (! $token = auth()->attempt($credentials)
     */
    public function testUserIsLoggedOutProperly()
    {
        $user = factory(User::class)->create(['email' => 'user@test.com', 'password'=>'123456']);
        $token = auth()->login($user);
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('get', '/api/clients', [], $headers)->assertStatus(200);
        $this->json('post', '/api/auth/logout', [], $headers)->assertStatus(200);

        $user = User::find($user->id);

        $this->assertEquals(null, $user->api_token);
    }

    public function testUserWithNullToken()
    {
        // Simulating login
        $user = factory(User::class)->create(['email' => 'user@test.com', 'password'=>'123456']);
        $token = auth()->login($user);
        $headers = ['Authorization' => "Bearer $token"];

        // Simulating logout
        auth()->invalidate();
        $user->save();

        $this->json('get', '/api/clients', [], $headers)->assertStatus(400);
    }
}
