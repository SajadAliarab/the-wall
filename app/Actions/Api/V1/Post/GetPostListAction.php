<?php

namespace App\Actions\Api\V1\Post;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class GetPostListAction
{
    public function handle(): LengthAwarePaginator
    {
        return Post::query()
            ->approved()
            ->with(['category', 'user', 'attachments'])
            ->orderByRaw('COALESCE(boosted_at, created_at) DESC')
            ->orderByDesc('id')
            ->paginate();
    }
}
