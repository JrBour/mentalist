<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    public function testUserShow()
    {
        $user = factory(User::class)->create();
        $response = $this->json('GET', route('users.show', ['user' => $user->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'firstname',
            'username',
            'admin',
            'name',
            'email'
        ]);
    }

    public function testUserShowFailed()
    {
        $response = $this->json('GET', route('users.show', ['user' => 999]));
        $response->assertStatus(404);
    }

    public function testUserShowList()
    {
        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'firstname',
                    'username',
                    'admin',
                    'name',
                    'email'
                ]
            ]
        ]);

    }

    public function testUserCreate()
    {
        $data = [
            'firstname' => 'Jean',
            'username' => 'jojo',
            'admin' => true,
            'name' => 'neige',
            'email' => 'tropMims@pipoute.com',
            'password' => 'ienclieddd'
        ];
        $this->post(route('users.store'), $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'firstname',
                'admin',
                'name',
                'email'
            ]);
    }
    public function testUserUpdate()
    {
        $data = [
            'firstname' => 'Jean',
            'username' => 'jojo',
            'admin' => true,
            'name' => 'neige',
            'email' => 'tropMims@pipoute.com',
            'password' => 'ienclieddd'
        ];
        $user = factory(User::class)->create();
        $this->put(route('users.update', ['user' => $user->id]), $data)
            ->assertStatus(200)
            ->assertJsonFragment([
                'firstname' => 'Jean',
                'username' => 'jojo',
                'admin' => true,
                'name' => 'neige',
                'email' => 'tropMims@pipoute.com',
            ])
            ->assertJsonStructure([
                'id',
                'firstname',
                'admin',
                'name',
                'email'
            ]);
    }

    public function testUserUpdateFail()
    {
        $data = [
            'firstname' => 'Jean',
            'username' => 'jojo',
            'admin' => true,
            'name' => 'neige',
            'email' => 'tropMims@pipoute.com',
            'password' => 'ienclieddd'
        ];
        $this->put(route('users.update', ['user' => 999]), $data)
            ->assertStatus(404);
    }

    public function testUserDelete()
    {
        $user = factory(User::class)->create();
        $this->delete(route('users.destroy', ['user' => $user->id]))
            ->assertStatus(204);
    }

    public function testUserDeleteFail()
    {
        $this->delete(route('users.destroy', ['user' => 999]))
            ->assertStatus(404);
    }
}
