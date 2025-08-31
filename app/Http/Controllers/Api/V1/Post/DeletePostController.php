<?php

namespace App\Http\Controllers\Api\V1\Post;

use App\Actions\Api\V1\Post\DeletePostAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Post;

class DeletePostController extends ApiBaseController
{
    public function __invoke(Post $post, DeletePostAction $action)
    {
        $action->handle($post);

        return response()->apiSuccess(
            messages: 'Post deleted successfully.',
        );
    }
}
