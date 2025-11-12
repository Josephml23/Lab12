<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Nota; // Asegúrate de añadir esto
use App\Observers\NotaObserver; // Asegúrate de añadir esto

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
        Nota::observe(NotaObserver::class);
    }
}