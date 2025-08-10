<?php

namespace App\Helpers;

class AppHelper
{
    public static function isDevMode(): bool
    {
        return config('app.debug')
            && app()->environment(['local', 'staging', 'testing']);
    }
}
