<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('website_settings')) {
                \Illuminate\Support\Facades\View::share('siteSettings', \App\Models\WebsiteSetting::first());
            }
        } catch (\Exception $e) {
            // Ignore for artisan commands
        }
    }
}
