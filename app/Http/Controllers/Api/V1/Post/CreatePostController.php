<?php

namespace App\Http\Controllers\Api\V1\Post;

use App\Actions\Api\V1\Post\CreatePostAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Post\CreatePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Http\Response;

class CreatePostController extends Controller
{
    public function __invoke(CreatePostRequest $request, CreatePostAction $action)
    {
        $post = $action->handle($request->toDto());
        $post->load('user', 'category');

        return response()->apiSuccess(
            data: new PostResource($post),
            messages: 'Post created successfully.',
            responseCode: Response::HTTP_CREATED
        );

    }
}
