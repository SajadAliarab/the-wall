<?php

namespace App\Http\Controllers\Api\V1\Post;

use App\Actions\Api\V1\Post\UpdatePostAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Api\V1\Post\UpdatePostRequest;
use App\Http\Resources\PostResource;
use Symfony\Component\HttpFoundation\Response;

class UpdatePostController extends ApiBaseController
{
    public function __invoke(int $postId, UpdatePostRequest $request, UpdatePostAction $action)
    {
        $post = $action->handle($request->toDto(), $postId);

        return response()->apiSuccess(
            data: new PostResource($post),
            messages: 'Post updated successfully.',
            responseCode: Response::HTTP_OK
        );
    }
}
