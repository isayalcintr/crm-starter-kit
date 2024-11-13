<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $helperFiles = glob(app_path('Helpers').'/*.php');
        foreach ($helperFiles as $file) {
            require_once $file;
        }
    }
}
