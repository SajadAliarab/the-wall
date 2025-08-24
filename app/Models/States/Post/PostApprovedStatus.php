<?php

namespace App\Models\States\Post;

class PostApprovedStatus extends PostStatus
{
    public static string $name = 'approved';

    public static function canBeDeleted(): bool
    {
        return true;
    }
}
