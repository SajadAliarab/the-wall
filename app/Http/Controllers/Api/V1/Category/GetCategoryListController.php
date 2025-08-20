<?php

namespace App\Http\Controllers\Api\V1\Category;

use App\Actions\Api\V1\Category\GetCategoryListAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\CategoryResource;

class GetCategoryListController extends ApiBaseController
{
    public function __invoke(GetCategoryListAction $action)
    {
        $categories = $action->handle();

        return response()->apiSuccess(
            data: CategoryResource::collection($categories),
        );
    }
}
