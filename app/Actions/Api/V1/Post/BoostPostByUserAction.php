<?php

namespace App\Actions\Api\V1\Post;

use App\Models\BoostPost;
use App\Models\Post;
use App\Notifications\BoostPostNotification;
use Illuminate\Auth\Access\AuthorizationException;

class BoostPostByUserAction
{
    public function handle(Post $post): BoostPost
    {
        $user = auth()->user();
        throw_if($post->user_id !== $user->id, new AuthorizationException);
        throw_if(! $post->status->canBeBoosts(), 'You can not boost this post');

        $boost = BoostPost::query()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
        $user->notify(new BoostPostNotification);

        return $boost->loadMissing(['post', 'user']);

    }
}
