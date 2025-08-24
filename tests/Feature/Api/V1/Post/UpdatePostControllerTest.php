<?php

use App\Models\Category;
use App\Models\Post;

it('update a post and return OK', function () {

    $category = Category::query()->create([
        'name' => 'Test Category',
    ]);

    $this->actingAs(createUser());
    $post = Post::query()->create([
        'title' => 'Test Post',
        'description' => 'Test Post',
        'price' => 100.10,
        'user_id' => createUser()->id,
        'category_id' => $category->id,
    ]);
    $title = 'Test Post Edit';

    $response = $this->putJson(route('api.v1.posts.update', $post->id), [
        'title' => $title,
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
            'images',
            'created_at',
            'updated_at',
        ],
    ]);
    $this->assertDatabaseHas('posts', [
        'title' => $title,
    ]);
});
