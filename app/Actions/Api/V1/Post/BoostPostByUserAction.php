<?php

namespace App\Actions\Api\V1\Post;

use App\Models\Post;
use App\Notifications\BoostPostNotification;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;

class BoostPostByUserAction
{
    public function handle(Post $post): Post
    {
        $user = auth()->user();
        throw_if($post->user_id !== $user->id, new AuthorizationException);

        throw_if(! $post->status->canBeBoosted(), new Exception('You can not boost this post'));

        $post->boosted_at = now();
        $post->save();

        $user->notify(new BoostPostNotification);

        return $post->loadMissing('user', 'category', 'attachments');
    }
}
