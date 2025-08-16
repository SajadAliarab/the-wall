<?php

use App\Models\User;

it('create token and return ok', function () {
    $email = 'test@gmail.com';
    $password = 'test';

    User::factory()->create([
        'email' => $email,
        'password' => Hash::make($password),
    ]);

    $response = $this->postJson(route('api.v1.auth.create-token'), [
        'email' => $email,
        'password' => $password,
        'device_name' => 'iphone13',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'data' => ['token'],
        ]);

    $this->assertDatabaseHas('users', [
        'email' => $email,
    ]);
});
