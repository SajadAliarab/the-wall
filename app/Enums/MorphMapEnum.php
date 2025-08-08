<?php

namespace App\Enums;

use App\Models\User;

enum MorphMapEnum: string
{
    case USER = 'user';

    public function modelClass(): string
    {
        return match ($this) {
            self::USER => User::class,
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $enum) => [
                $enum->value => $enum->modelClass(),
            ])
            ->toArray();
    }
}
