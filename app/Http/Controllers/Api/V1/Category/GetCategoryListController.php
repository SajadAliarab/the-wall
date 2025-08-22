<?php

namespace App\Http\Controllers\Api\V1\Category;

use App\Actions\Api\V1\Category\GetCategoryListAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\CategoryResource;
use Symfony\Component\HttpFoundation\Response;

class GetCategoryListController extends ApiBaseController
{
    public function __invoke(GetCategoryListAction $action)
    {
        $categories = $action->handle();

        return response()->apiSuccess(
            data: CategoryResource::collection($categories),
            messages: "Category list found.",
            responseCode:Response::HTTP_OK
        );
    }
}
