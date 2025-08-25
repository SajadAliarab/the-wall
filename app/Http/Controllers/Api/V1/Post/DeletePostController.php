<?php

namespace App\Http\Controllers\Api\V1\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Actions\Api\V1\Post\DeletePostAction;

class DeletePostController extends Controller
{
    public function __invoke(Post$post ,DeletePostAction $action)
    {
        $delete = $action->handle($post);

        return response()->apiSuccess();

    }
}
