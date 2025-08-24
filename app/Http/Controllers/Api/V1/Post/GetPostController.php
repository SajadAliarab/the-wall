<?php

namespace App\Http\Controllers\Api\V1\Post;

use App\Actions\Api\V1\Post\GetPostAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\PostResource;
use Symfony\Component\HttpFoundation\Response;

class GetPostController extends ApiBaseController
{
    public function __invoke(GetPostAction $action)
    {
        $post = $action->handle();

        return response()->apiSuccess(
            data: PostResource::collection($post),
            messages: 'Get posts successfully.',
            responseCode: Response::HTTP_OK
        );

    }
}
