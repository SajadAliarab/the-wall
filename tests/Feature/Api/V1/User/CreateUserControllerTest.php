<?php

use App\Models\User;
use App\Notifications\CreateUserNotification;
use Illuminate\Support\Facades\Notification;

it('create user and return ok', function () {
    Notification::fake();
    $name = 'Test User';
    $email = 'test@test.com';
    $password = 'Te$t12345678';
    $password_confirmation = 'Te$t12345678';

    $response = $this->postJson(route('api.v1.users.create'), [
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'password_confirmation' => $password_confirmation,
    ]);

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'success',
        'messages',
        'data' => [
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ],
    ]);
    $this->assertDatabaseHas('users', [
        'email' => $email,
    ]);
    $user = User::query()->where('email', $email)->first();
    Notification::assertSentTo($user, CreateUserNotification::class);

});
