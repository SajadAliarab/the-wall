<?php

namespace App\Actions\Api\V1\Post;

use App\DataTransferObject\Post\CreatePostDto;
use App\Models\Post;

class CreatePostAction
{
    public function handle(CreatePostDto $dto): Post
    {
        $post = Post::query()->create([
            'title' => $dto->title,
            'description' => $dto->description,
            'price' => $dto->price,
            'user_id' => auth()->user()->id,
            'category_id' => $dto->category_id,
        ]);

        return $post->loadMissing('user', 'category');
    }
}
