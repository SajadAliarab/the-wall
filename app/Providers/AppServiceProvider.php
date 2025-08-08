<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
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

        // Use immutable dates.
        Date::use(CarbonImmutable::class);

        // Prevent accessing attributes that were not loaded from the database. Instead of returning null, an exception will be thrown
        Model::preventAccessingMissingAttributes();

        // No mass assignment protection at all.
        Model::unguard();

        Model::automaticallyEagerLoadRelationships();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
