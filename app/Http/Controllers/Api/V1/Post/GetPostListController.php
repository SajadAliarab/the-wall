<?php

namespace App\Http\Controllers\Api\V1\Post;

use App\Actions\Api\V1\Post\GetPostListAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\PostResource;

class GetPostListController extends ApiBaseController
{
    public function __invoke(GetPostListAction $action)
    {
        $paginatedPosts = $action->handle();

        return response()->apiSuccess(
            data: PostResource::collection($paginatedPosts),
            hasPagination: true,
        );
    }
}
