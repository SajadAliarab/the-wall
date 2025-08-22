<?php

namespace App\Actions\Api\V1\Post;

use App\DataTransferObject\Post\CreatePostDto;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreatePostAction
{
    public function handle(CreatePostDto $dto): Post
    {
        DB::beginTransaction();

        try {
            $post = Post::query()->create([
                'title' => $dto->title,
                'description' => $dto->description,
                'price' => $dto->price,
                'user_id' => auth()->user()->id,
                'category_id' => $dto->category_id,
            ]);

            $post->attachments()->attach($dto->images);

        } catch (Throwable $th) {
            DB::rollBack();

            throw $th;
        }

        DB::commit();

        return $post->loadMissing('user', 'category', 'attachments');
    }
}
