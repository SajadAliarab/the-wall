<?php

namespace App\Console\Commands;

use App\Models\Post;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

class DeletePosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Force delete posts that were soft deleted until yesterday';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $yesterday = CarbonImmutable::yesterday()->endOfDay();
        Post::query()->onlyTrashed()
            ->where('deleted_at', '<=', $yesterday)
            ->forceDelete();
        echo 'All posts force deleted successfully';
    }
}
