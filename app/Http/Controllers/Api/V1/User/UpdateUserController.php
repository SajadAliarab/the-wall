<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\Api\V1\User\UpdateUserAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Api\V1\User\UpdateUserRequest;
use App\Http\Resources\UserResource;

class UpdateUserController extends ApiBaseController
{
    public function __invoke(UpdateUserRequest $request, UpdateUserAction $action)
    {
        $user = $action->handle($request->toDto());

        return response()->apiSuccess(
            data: new UserResource($user),
            messages: 'User updated successfully.',
        );
    }
}
