<form id="form-tipo-seguro-update" action="{{route('unidad-medida.editar',$unidad)}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="col-lg-12">
            <label for="nombre">Nombre</label>
            <input  maxlength="100" id="nombre" name="nombre" class="form-control required" value="{{$unidad->nombre}}">
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-lg-12">
            <label for="descripcion">Descripción</label>
            <textarea maxlength="300" id="descripcion" class="form-control required" name="descripcion" rows="4">{{$unidad->descripcion}}</textarea>
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
            @forelse($unidad->bitacora as $bitacora)
                <tr>
                    <td>{{$bitacora->nombre}}</td>
                    <td>{{$bitacora->descripcion}}</td>
                    <td>#</td>
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