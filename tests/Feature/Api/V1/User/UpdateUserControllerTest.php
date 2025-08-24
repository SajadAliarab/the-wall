<?php

it('update user and return ok', function () {

    $this->actingAs(createUser());

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
