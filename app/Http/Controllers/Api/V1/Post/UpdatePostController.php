<?php

namespace App\Http\Controllers\Api\V1\Post;

use App\Actions\Api\V1\Post\UpdatePostAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Api\V1\Post\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;

class UpdatePostController extends ApiBaseController
{
    public function __invoke(Post $post, UpdatePostRequest $request, UpdatePostAction $action)
    {
        $post = $action->handle($post, $request->toDto());

        return response()->apiSuccess(
            data: new PostResource($post),
            messages: 'Post updated successfully.',
        );
    }
}
