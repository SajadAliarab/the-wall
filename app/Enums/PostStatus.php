<?php

namespace App\Enums;

enum PostStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
