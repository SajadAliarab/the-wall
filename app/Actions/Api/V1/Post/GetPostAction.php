<?php

namespace App\Actions\Api\V1\Post;

use App\Models\Post;
use Illuminate\Support\Collection;

class GetPostAction
{
    public function handle(): Collection
    {
        return Post::query()
            ->approved()
            ->with(['category', 'user', 'attachments'])
            ->orderBy('created_at', 'DESC')
            ->get();
    }
}
