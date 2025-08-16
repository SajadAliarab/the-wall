<?php

namespace App\Actions\Api\V1\Auth;

use App\DataTransferObject\Auth\CreateTokenDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CreateTokenAction
{
    public function handle(CreateTokenDto $createTokenDto): string
    {
        $user = User::query()
            ->where('email', $createTokenDto->email)
            ->first();

        throw_if(! $user || ! Hash::check($createTokenDto->password, $user->password), ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]));

        return $user
            ->createToken($createTokenDto->deviceName)
            ->plainTextToken;
    }
}
