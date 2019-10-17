<?php

namespace App\Providers;

use App\Models\TipoSeguro;
use App\Observers\TipoSeguroObserver;
use Illuminate\Support\ServiceProvider;

class ModelProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        TipoSeguro::observe(TipoSeguroObserver::class);

    }
}
