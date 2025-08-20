<?php

it('update user and return ok', function () {
    $name = 'Test User';
    $email = 'test@test.com';
    $password = 'password';
    $user = \App\Models\User::factory()->create([
        'name' => $name,
        'email' => $email,
        'password' => $password,
    ]);
    $this->actingAs($user);

    $response = $this->putJson(route('api.v1.users.update'), [
        'name' => 'New Name',
    ]);
    $response->assertStatus(200);
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
        'name' => 'New Name',
    ]);

});
