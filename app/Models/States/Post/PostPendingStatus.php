<?php

namespace App\Models\States\Post;

class PostPendingStatus extends PostStatus
{
    public static string $name = 'pending';

    public static function canBeDeleted(): bool
    {
        return true;
    }

    public static function canBeBoosted(): bool
    {
        return false;
    }
}
