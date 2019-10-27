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
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa  fa-users"></i>
                <span>Gestión de personas</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{route('persona.index','paciente')}}"><i class="fa fa-circle-o"></i> Gestión de pacientes</a></li>
                <li><a href="{{route('persona.index','medico')}}"><i class="fa fa-circle-o"></i> Gestión de médicos</a></li>
            </ul>
        </li>
        <li class="treeview">
        <a href="#">
            <i class="fa  fa-bar-chart"></i>
            <span>Reportes</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{route('dashboard.index',['paciente-atendido','paciente'])}}"><i class="fa fa-circle-o"></i> Paciente atendido</a></li>
            <li><a href="{{route('dashboard.index',['medico-examen-emision','empleado'])}}"><i class="fa fa-circle-o"></i> Profesional médico</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Profesional de laboratorio</a></li>
            <li><a href="{{route('dashboard.stock-insumo')}}"><i class="fa fa-circle-o"></i>Insumos</a></li>
            <li><a href="{{route('persona.index','medico')}}"><i class="fa fa-circle-o"></i> Producción general del mes</a></li>
            <li><a href="{{route('persona.index','medico')}}"><i class="fa fa-circle-o"></i> Tiempo promedio de atención</a></li>
            <li><a href="{{route('persona.index','medico')}}"><i class="fa fa-circle-o"></i> Patologias anormales</a></li>
        </ul>
    </li>
        <li>
            <a href="{{route('usuario.index')}}">
                <i class="fa  fa-user"></i> <span>Gestión de usuarios</span>
            </a>
        </li>
        <li>
            <a href="{{route('registro-analisis.index')}}">
                <i class="fa  fa-heartbeat"></i> <span>Gestión de Análisis</span>
            </a>
        </li>
</ul>

