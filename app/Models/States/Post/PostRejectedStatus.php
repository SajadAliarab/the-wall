<?php

namespace App\Models\States\Post;

class PostRejectedStatus extends PostStatus
{
    public static string $name = 'rejected';

    public static function canBeDeleted(): bool
    {
        return false;
    }

    public static function canBeBoosted(): bool
    {
        return false;
    }
}
