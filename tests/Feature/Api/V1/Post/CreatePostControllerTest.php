<?php

use App\Models\Category;

it('creat a post and return OK', function () {

    $category = Category::query()->create([
        'name' => 'Test Category',
    ]);
    $this->actingAs(createUser());
    $title = 'Test Post';
    $description = 'Test Description for post';
    $price = 99.99;
    $response = $this->postJson(route('api.v1.posts.create'), [
        'title' => $title,
        'description' => $description,
        'price' => $price,
        'category_id' => $category->id,
    ]);
    $response->assertStatus(201);
    $response->assertJsonStructure([
        'success',
        'messages',
        'data' => [
            'title',
            'description',
            'price',
            'user',
            'category',
            'created_at',
            'updated_at',
        ],
    ]);
    $this->assertDatabaseHas('posts', [
        'title' => $title,
    ]);
});
