<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCreation()
    {
        $user = factory(User::class)->create();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'firstname' => $user->firstname,
            'username' => $user->username,
            'name' => $user->name,
            'admin' => $user->admin,
            'email' => $user->email,
            'email_hashed' => $user->email_hashed,
            'password' => $user->password,
            'remember_token' => $user->remember_token
        ]);
    }

    public function testUserDelete()
    {
        $user = factory(User::class)->create();
        $this->assertTrue($user->delete());
    }
}