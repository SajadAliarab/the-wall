<?php

namespace App\Actions\Api\V1\Post;

use App\Models\Post;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class GetPostListAction
{
    public function handle(): LengthAwarePaginator
    {
        $latestBoosts = DB::table('boost_posts')
            ->select('post_id', DB::raw('MAX(created_at) as last_boosted_at'))
            ->groupBy('post_id');

        return Post::query()
            ->approved()
            ->with(['category', 'user', 'attachments'])
            ->leftJoinSub($latestBoosts, 'lb', function (JoinClause $join) {
                $join->on('posts.id', '=', 'lb.post_id');
            })
            ->select('posts.*', 'lb.last_boosted_at')
            ->orderByRaw('COALESCE(lb.last_boosted_at, posts.created_at) DESC')
            ->orderByDesc('posts.id')
            ->paginate();
    }
}
