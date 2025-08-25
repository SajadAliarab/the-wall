<?php

namespace App\Models\States\Post;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class PostStatus extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(PostPendingStatus::class)
            ->allowTransitions([
                // Pending => Rejected, Approved
                [PostPendingStatus::class, PostRejectedStatus::class],
                [PostPendingStatus::class, PostApprovedStatus::class],

                // Approved => Rejected, Pending
                [PostApprovedStatus::class, PostPendingStatus::class],
                [PostApprovedStatus::class, PostRejectedStatus::class],

                // Rejected => Pending
                [PostRejectedStatus::class, PostPendingStatus::class],
            ]);
    }

    abstract public static function canBeDeleted(): bool;
}
