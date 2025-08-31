<?php

namespace App\Actions\Api\V1\Post;

use App\Models\Post;
use App\Notifications\DeletePostNotification;
use Illuminate\Auth\Access\AuthorizationException;

class DeletePostAction
{
    public function handle(Post $post): bool
    {
        throw_if($post->user_id !== auth()->user()->id, new AuthorizationException);

        throw_if(! $post->status->canBeDeleted(), 'In this Status you can not delete this post');

        $isPostDeleted = $post->delete();
        if ($isPostDeleted) {
            $user = auth()->user();
            $user->notify(new DeletePostNotification);
        }

        return $isPostDeleted;
    }
}
