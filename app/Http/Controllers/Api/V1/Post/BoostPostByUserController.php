<?php

namespace App\Http\Controllers\Api\V1\Post;

use App\Actions\Api\V1\Post\BoostPostByUserAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\BoostPostResource;
use App\Models\Post;

class BoostPostByUserController extends ApiBaseController
{
    public function __invoke(Post $post, BoostPostByUserAction $action)
    {
        $boost = $action->handle($post);

        return response()->apiSuccess(
            data: new BoostPostResource($boost),
        );

    }
}
