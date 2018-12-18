<?php

namespace Tests\Unit;

use App\Model\Client;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testsClientsAreCreatedCorrectly()
    {

        $user = factory(User::class)->create(['email' => 'user@test.com', 'password'=>'123456']);
        $token = auth()->login($user);
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'first_name' => 'Lorem',
            'email' => 'Ipsum@i.ua',
        ];

        $this->json('POST', '/api/clients', $payload, $headers)
            ->assertStatus(201)
            ->assertJson([
                "createdClient" => [
                    'id' => 1,
                    'first_name' => 'Lorem',
                    'email' => 'Ipsum@i.ua',
                    'contacts' => [],
                ]
            ]);
    }

    public function testsClientsAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create(['email' => 'user@test.com', 'password'=>'123456']);
        $token = auth()->login($user);
        $headers = ['Authorization' => "Bearer $token"];
        $client = factory(Client::class)->create([
            'first_name' => 'FirstManTest',
            'email' => 'man@i.ua',
        ]);

        $payload = [
            'first_name' => 'Lorem',
            'email' => 'Ipsum2@i.ua',
        ];

        $response = $this->json('PUT', '/api/clients/' . $client->id, $payload, $headers)
            ->assertStatus(201)
            ->assertJson([
                "client" => [
                    'id' => 1,
                    'first_name' => 'Lorem',
                    'email' => 'Ipsum2@i.ua',
                    'contacts' => [],
                ]
            ]);
    }

    public function testsClientsAreDeletedCorrectly()
    {
        $user = factory(User::class)->create(['email' => 'user@test.com', 'password'=>'123456']);
        $token = auth()->login($user);
        $headers = ['Authorization' => "Bearer $token"];
        $client = factory(Client::class)->create([
            'first_name' => 'FirstManTest',
            'email' => 'man@i.ua',
        ]);

        $this->json('DELETE', '/api/clients/' . $client->id, [], $headers)
            ->assertStatus(204);
    }


    public function testClientssAreListedCorrectly()
    {
        factory(Client::class)->create([
            'first_name' => 'FirstManTest',
            'email' => 'man@i.ua',
        ]);

        factory(Client::class)->create([
            'first_name' => 'SecondManTest',
            'email' => 'man2@i.ua',
        ]);

        $user = factory(User::class)->create(['email' => 'user@test.com', 'password'=>'123456']);
        $token = auth()->login($user);
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/clients', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    ['first_name' => 'FirstManTest', 'email' => 'man@i.ua', "contacts" => []],
                    [ 'first_name' => 'SecondManTest', 'email' => 'man2@i.ua', "contacts" => [] ]
                ]
            ]);
    }
}
