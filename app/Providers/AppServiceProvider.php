<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Perfil;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Relation::morphMap([
            'menu'=>Menu::class,
            'perfil'=>Perfil::class
        ]);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
