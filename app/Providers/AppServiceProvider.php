<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // Force les URLs générées (assets Vite, url(), route()) en HTTPS en
        // production. Nécessaire car Railway termine le HTTPS au niveau de
        // son proxy et transmet la requête en HTTP en interne — sans ça,
        // Laravel génère des liens CSS/JS en http:// que le navigateur
        // bloque silencieusement (contenu mixte) sur une page HTTPS.
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}