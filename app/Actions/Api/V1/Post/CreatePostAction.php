<?php

namespace App\Actions\Api\V1\Post;

use App\DataTransferObject\Post\CreatePostDto;
use App\Models\Post;
use App\Models\States\Post\PostPendingStatus;
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
                'status' => PostPendingStatus::class,
            ]);

            $post->attachments()->attach($dto->images);
            $post->attributes()->attach(
                $dto->attributes->map(fn (mixed $value):array => ['value' => $value])->toArray()
            );


        } catch (Throwable $th) {
            DB::rollBack();

            throw $th;
        }

        DB::commit();

        return $post->loadMissing('user', 'category', 'attachments','attributes');
    }
}
