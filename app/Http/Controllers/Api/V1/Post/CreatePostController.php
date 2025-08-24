<?php

namespace App\Http\Controllers\Api\V1\Post;

use App\Actions\Api\V1\Post\CreatePostAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Api\V1\Post\CreatePostRequest;
use App\Http\Resources\PostResource;
use Symfony\Component\HttpFoundation\Response;

class CreatePostController extends ApiBaseController
{
    public function __invoke(CreatePostRequest $request, CreatePostAction $action)
    {
        $post = $action->handle($request->toDto());

        return response()->apiSuccess(
            data: new PostResource($post),
            messages: 'Post created successfully.',
            responseCode: Response::HTTP_CREATED
        );

    }
}
