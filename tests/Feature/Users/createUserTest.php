<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class createUserTest extends TestCase
{
    /** @test */
    public function it_should_be_able_to_create_an_account()
    {
        $response = $this->postJson(route('api.users.store', [
            'name' => 'user name',
            'email' => 'user@email.com',
            'password' => 'password',
        ]));

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'user' => ['api_key', 'token']
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'user@email.com'
        ]);
    }

    /** @test */
    public function it_should_be_able_to_admin_users_create_an_account()
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)
            ->postJson(route('api.users.store-admin', [
                'name' => 'user name',
                'email' => 'user@email.com',
                'password' => 'password',
            ]));

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'user' => ['api_key', 'token']
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'user@email.com'
        ]);
    }
}
