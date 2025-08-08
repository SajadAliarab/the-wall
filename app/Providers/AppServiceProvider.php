<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Use HTTPS in production
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        // Prohibits: db:wipe, migrate:fresh, migrate:refresh, and migrate:reset
        DB::prohibitDestructiveCommands(app()->isProduction());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
