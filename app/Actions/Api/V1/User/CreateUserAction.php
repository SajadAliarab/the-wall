<?php

namespace App\Actions\Api\V1\User;

use App\DataTransferObject\User\CreateUserDto;
use App\Models\User;
use App\Notifications\CreateUserNotification;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateUserAction
{
    public function handle(CreateUserDto $dto): User
    {
        DB::beginTransaction();

        try {
            $user = User::query()->create([
                'name' => $dto->name,
                'email' => $dto->email,
                'password' => $dto->password,
            ]);
            $user->notify(new CreateUserNotification);
        } catch (Throwable $th) {
            DB::rollBack();

            throw $th;
        }
        DB::commit();

        return $user;

    }
}
