<form id="form-tipo-seguro-update" action="{{route('tipo-seguro.editar',$seguro)}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="col-lg-12">
            <label for="nombre">Nombre</label>
            <input maxlength="20" id="nombre" name="nombre" class="form-control required" value="{{$seguro->nombre}}">
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-lg-12">
            <label for="descripcion">Descripción</label>
            <textarea maxlength="300" id="descripcion" class="form-control required" name="descripcion" rows="4">{{$seguro->descripcion}}</textarea>
        </div>
    </div>
</form>
<hr>

<div class="row" style="font-size: 12px;">
    <div class="col-lg-12">
        <label>Historial de cambios</label>
        <table class="table">
            <thead style="background-color: #3c8dbc; color: white">
            <tr>
                <td>Nombre</td>
                <td>Descripción</td>
                <td>Usuario</td>
                <td>Fecha</td>
            </tr>
            </thead>
            <tbody>
            @forelse($seguro->bitacora as $bitacora)
                <tr>
                    <td>{{$bitacora->nombre}}</td>
                    <td>{{$bitacora->descripcion}}</td>
                    <td>{{$bitacora->usuario_accion ? $bitacora->usuario_accion->usuario : ''}}</td>
                    <td>{{$bitacora->fecha_accion}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">
                        No existe cambios registrados
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
