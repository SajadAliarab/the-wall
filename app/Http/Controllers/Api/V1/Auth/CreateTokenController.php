<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Api\V1\Auth\CreateTokenAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Api\V1\Auth\CreateTokenRequest;
use App\Http\Resources\AuthResource;

class CreateTokenController extends ApiBaseController
{
    public function __invoke(CreateTokenRequest $request, CreateTokenAction $action)
    {
        $token = $action->handle($request->toDto());

        return response()->apiSuccess(
            data: new AuthResource($token),
            messages: 'Token created successfully.',
        );
    }
}
