<?php

namespace Tests\Feature\Users;

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
}
