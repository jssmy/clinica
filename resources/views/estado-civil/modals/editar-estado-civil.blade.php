<form id="form-update" action="{{route('estado-civil.editar',$estado)}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="col-lg-12">
            <label for="nombre">Nombre</label>
            <input id="nombre" name="nombre" class="form-control required" value="{{$estado->nombre}}">
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-lg-12">
            <label>Historial de acciones</label>
            <table class="table table-hover table-striped" style="font-size:13px;">
                <thead style="background-color: #3c8dbc; color: white">
                <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Usuario acción</th>
                    <th>Fecha acción</th>
                </tr>
                </thead>
                <tbody>
                @foreach($estado->bitacora as $bitacora)
                    <tr>
                    <td>{{$bitacora->nombre}}</td>
                    <td>{{$bitacora->estado ? 'ACTIVO' : 'INACTIVO' }}</td>
                    <td>{{$bitacora->usuario_accion ? $bitacora->usuario_accion->usuario : '' }}</td>
                    <td>{{$bitacora->fecha_accion}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</form>
