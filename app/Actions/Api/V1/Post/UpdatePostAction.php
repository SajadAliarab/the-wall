<?php

namespace App\Actions\Api\V1\Post;

use App\DataTransferObject\Post\UpdatePostDto;
use App\Enums\PostStatusEnum;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class UpdatePostAction
{
    public function handle(UpdatePostDto $dto, int $postId): Post
    {
        DB::beginTransaction();

        try {
            $post = \App\Models\Post::query()->findOrFail($postId);
            throw_if($post->user_id !== auth()->user()->id, new \Exception('unauthorized to update this post'));
            $updateData = array_filter([
                'title' => $dto->title,
                'description' => $dto->description,
                'price' => $dto->price,
                'category_id' => $dto->category_id,
            ], fn (mixed $value): bool => $value !== null);
            if (filled($updateData)) {
                $updateData['status'] = PostStatusEnum::Pending->value;
                $post->update($updateData);
            }
            if ($dto->images !== null) {
                $post->attachments()->sync($dto->images);
            }

        } catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
        DB::commit();

        return $post->loadMissing('user', 'category', 'attachments');

    }
}
