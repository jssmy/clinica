<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 27/10/2019
 * Time: 18:43
 */

namespace App\Providers;


use App\Utils\View\MenuComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.partials.menu',MenuComposer::class);


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
