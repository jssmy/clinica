<form id="form-update" action="{{route('examen-cab.editar',$examen)}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="col-lg-12">
            <label for="nombre">Nombre</label>
            <input maxlength="100" id="nombre" name="nombre" class="form-control required" value="{{$examen->nombre}}">
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-lg-12">
            <label for="descripcion">Descripción</label>
            <textarea maxlength="500" id="descripcion" class="form-control required" name="descripcion" rows="4">{{$examen->descripcion}}</textarea>
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-sm-12">
            <label>Historial de acciones</label>
            <table class="table table-hover table-striped" style="font-size:13px;">
                <thead style="background-color: #3c8dbc; color: white">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Usuario acción</th>
                        <th>Fecha acción</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($examen->bitacora as $bitacora)
                    <tr>
                        <td>{{$bitacora->nombre}}</td>
                        <td>{{$bitacora->descripcion}}</td>
                        <td>{{$bitacora->estado ? 'ACTIVO' : 'INACTIVO'}}</td>
                        <td>{{$bitacora->usuario_accion->usuario}}</td>
                        <td>{{$bitacora->fecha_accion}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</form>
