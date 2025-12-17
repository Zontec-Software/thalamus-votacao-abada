<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Força HTTPS em produção (quando APP_URL usar HTTPS)
        $appUrl = env('APP_URL', '');
        if (!empty($appUrl) && str_starts_with($appUrl, 'https://')) {
            URL::forceScheme('https');
        }
    }
}
