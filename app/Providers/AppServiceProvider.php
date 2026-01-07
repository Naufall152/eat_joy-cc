<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // === SOLUSI PERMANEN AZURE ===
        
        // 1. Memaksa Laravel membuat link HTTPS
        URL::forceScheme('https');

        // 2. Memanipulasi Request agar Laravel sadar ini HTTPS
        // (Penting untuk mengatasi Error 419 Page Expired)
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'off') {
            unset($_SERVER['HTTPS']);
        }
        
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            $_SERVER['HTTPS'] = 'on';
        }

        $this->app['request']->server->set('HTTPS', 'on');
    }
}
