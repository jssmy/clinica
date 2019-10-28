<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 27/10/2019
 * Time: 18:35
 */

namespace App\Utils\View;
use App\Models\Menu;
use Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class MenuComposer
{

    public function compose(View $view)
    {

        Artisan::call('cache:clear');
        //cache()->clear();

        $menus = Cache::rememberForever('menu-'.auth()->id(), function () {

            $menu_ids = $this->getMenuFromPerfil();

            return Menu::visible()
                ->padre()
                ->with(['subMenu'=>function($query) use ($menu_ids){
                    $query->hijo()->whereIn('id',$menu_ids);
                }])
                ->whereIn('id', $menu_ids)
                ->get();
        });
        return $view->with('menus', $menus);
    }

    protected function getMenuFromPerfil()
    {
        $menu_ids = collect();

        $perfil = auth()->user()
            ->perfil()
            ->with(['menus' => function($q){
                $q->visible();
            }])
           ->first();

            $perfil->menus->each(function ($menu) use ($menu_ids){
                $menu_ids->push($menu->id);
            });
            return $menu_ids->unique();
    /*
     *
        $perfiles->each(function($perfil) use ($menu_ids){
            $perfil->menus->each(function($menu) use ($menu_ids){
                $menu_ids->push($menu->id);
            });
        });

        $menus = auth()->user()
            ->menus()
            ->visible()
            ->get();

        $menus->each(function($menu) use ($menu_ids){
            $menu_ids->push($menu->id);
        });

        return $menu_ids->unique();
    */
    }

}
