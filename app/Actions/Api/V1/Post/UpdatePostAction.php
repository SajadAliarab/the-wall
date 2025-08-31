<?php

namespace App\Actions\Api\V1\Post;

use App\DataTransferObject\Post\UpdatePostDto;
use App\Models\Post;
use App\Models\States\Post\PostPendingStatus;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;

class UpdatePostAction
{
    public function handle(Post $post, UpdatePostDto $dto): Post
    {
        throw_if($post->user_id !== auth()->user()->id, new AuthorizationException);

        DB::beginTransaction();

        try {
            $post->title = $dto->title;
            $post->description = $dto->description;
            $post->price = $dto->price;
            $post->category_id = $dto->category_id;

            $post->attachments()->sync($dto->images);

            $post->attributes()->sync(
                $dto->attributes->map(fn (mixed $value): array => ['value' => $value])->toArray()
            );

            $post->status->transitionTo(PostPendingStatus::class);

        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

        DB::commit();

        return $post->loadMissing('user', 'category', 'attachments', 'attributes');
    }
}
