<?php

namespace App\Actions\Api\V1\Users;

use App\DataTransferObject\User\CreateUserDto;
use App\Models\User;
use App\Notifications\CreateUserNotification;

class CreateUserAction
{
    public function handle(CreateUserDto $dto): User
    {
        $user = User::query()->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
        ]);
        $user->notify(new CreateUserNotification);

        return $user;

    }
}
