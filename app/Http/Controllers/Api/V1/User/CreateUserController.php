<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\Api\V1\User\CreateUserAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Api\V1\User\CreateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;

class CreateUserController extends ApiBaseController
{
    public function __invoke(CreateUserRequest $request, CreateUserAction $action)
    {
        $user = $action->handle($request->toDto());

        return response()->apiSuccess(
            data: new UserResource($user),
            messages: 'User created successfully.',
            responseCode: Response::HTTP_CREATED,
        );
    }
}
