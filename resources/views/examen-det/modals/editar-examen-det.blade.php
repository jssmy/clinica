<form id="form-update" action="{{route('examen-det.editar',$examen)}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="col-sm-12">
            <label>Tipo de examen</label>
            <input type="hidden" name="tipo_examen" value="{{$examen->examen_cab_id}}">
            <input type="text" readonly class="form-control" value="{{$examen->tipo_examen->nombre}}">
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
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
        <div class="col-lg-12">
            <label for="descripcion">Historial de acciones</label>
            <table class="table table-hover table-striped" style="font-size:13px;">
                <thead style="background-color: #3c8dbc; color: white">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Usuario Registro</th>
                    <th>Fecha Registro</th>
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
