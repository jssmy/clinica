<form id="form-update" action="{{route('perfil.editar',$perfil)}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="col-lg-12">
            <label for="codigo">Perfil</label>
            <input maxlength="3" id="codigo" name="perfil" class="form-control required" value="{{$perfil->id}}">
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-lg-12">
            <label for="descripcion">Descripción</label>
            <textarea maxlength="50"  id="descripcion" class="form-control required" name="descripcion" rows="3">{{$perfil->descripcion}}</textarea>
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-sm-12">
            <label>Historial de acciones</label>
            <table class="table table-hover table-striped" style="font-size:13px;">
                <thead style="background-color: #3c8dbc; color: white">
                <tr>
                    <th>Perfil</th>
                    <th>Descripcion</th>
                    <th>Estado</th>
                    <th>Usuario acción</th>
                    <th>Fecha acción</th>
                </tr>
                </thead>
                <tbody>
                @foreach($perfil->bitacora as $bitacora)
                    <tr>
                        <td>{{$bitacora->perfil_id}}</td>
                        <td>{{$bitacora->descripcion}}</td>
                        <td>{{$bitacora->estado ? 'ACTIVO' : 'INACTIVO'}}</td>
                        <td>{{$bitacora->usuario_accion ?  $bitacora->usuario_accion->usuario : '' }}</td>
                        <td>{{$bitacora->fecha_accion}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</form>
