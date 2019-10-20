<ul class="sidebar-menu" data-widget="tree">
        <li class="header">OPCIONES</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-gear"></i>
            <span>Configuración del sistema</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('tipo-seguro.index')}}"><i class="fa fa-circle-o"></i> Tipo de Seguro</a></li>
            <li><a href="{{route('unidad-medida.index')}}"><i class="fa fa-circle-o"></i> Unidad de Medida</a></li>
            <li><a href="{{route('insumo.index')}}"><i class="fa fa-circle-o"></i> Insumo</a></li>
            <li><a href="{{route('estado-civil.index')}}"><i class="fa fa-circle-o"></i> Estado Civil</a></li>
            <li><a href="{{route('perfil.index')}}"><i class="fa fa-circle-o"></i> Perfil</a></li>
            <li><a href="{{route('examen-cab.index')}}"><i class="fa fa-circle-o"></i> Tipo de examen</a></li>
            <li><a href="{{route('examen-det.index')}}"><i class="fa fa-circle-o"></i> Sub Tipo de examen</a></li>
          </ul>
        <li>
            <a href="{{route('persona.index')}}">
                <i class="fa  fa-users"></i> <span>Gestión de Personas</span>
            </a>
        </li>
        <li>
        <a href="{{route('registro-analisis.index')}}">
            <i class="fa  fa-heartbeat"></i> <span>Gestión de Análisis</span>
        </a>
        </li>
</ul>
