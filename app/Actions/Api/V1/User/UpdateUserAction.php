<?php

namespace App\Actions\Api\V1\User;

use App\DataTransferObject\User\UpdateUserDto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UpdateUserAction
{
    public function handle(UpdateUserDto $dto): User
    {
        $user = Auth::user();
        $user->name = $dto->name;
        $user->save();

        return $user;
    }
}
