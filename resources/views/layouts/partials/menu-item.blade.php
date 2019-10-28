@if($menu->has_sub_menu)
    <li class="treeview">
        <a href="#">
            <i class="{{$menu->icono}}"></i>
            <span>{{$menu->nombre}}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            @foreach($menu->subMenu as $subMenu)
                <li><a href="{{ Route::has($subMenu->route) ? route($subMenu->route) : '#' }}"><i class="{{$subMenu->icono}}"></i> {{$subMenu->nombre}}</a></li>
            @endforeach
        </ul>
    </li>
@else
    <li>
        <a href="{{ Route::has($menu->route) ? route($menu->route) : '#' }}">
            <i class="{{$menu->icono}}"></i> <span>{{$menu->nombre}}</span>
        </a>
    </li>
@endif
