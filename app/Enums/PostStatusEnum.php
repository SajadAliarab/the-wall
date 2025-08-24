<?php

namespace App\Enums;

enum PostStatusEnum: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
