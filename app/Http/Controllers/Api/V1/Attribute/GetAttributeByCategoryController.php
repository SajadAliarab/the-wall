<?php

namespace App\Http\Controllers\Api\V1\Attribute;

use App\Actions\Api\V1\Attribute\GetAttributeByCategoryAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\AttributeResource;
use App\Models\Category;

class GetAttributeByCategoryController extends ApiBaseController
{
    public function __invoke(GetAttributeByCategoryAction $action, Category $category)
    {
        $attributes = $action->handle($category);

        return response()->apiSuccess(
            data: AttributeResource::collection($attributes)
        );

    }
}
