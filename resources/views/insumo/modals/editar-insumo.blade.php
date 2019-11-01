<form id="form-update" action="{{route('insumo.editar',$insumo)}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="col-lg-12">
            <label for="nombre">Nombre</label>
            <input maxlength="100" id="nombre" name="nombre" class="form-control required" value="{{$insumo->nombre}}">
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-lg-12">
            <label for="descripcion">Descripción</label>
            <textarea maxlength="500" id="descripcion" class="form-control required" name="descripcion" rows="3">{{$insumo->descripcion}}</textarea>
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-lg-12">
            <label for="uso">Uso</label>
            @if($insumo->tipo_examen)
                <input type="hidden" name="uso" value="{{$insumo->examen_cab_id}}">
                <input readonly type="text" class="form-control" value="{{$insumo->tipo_examen ? $insumo->tipo_examen->nombre : ''}}">
            @else
                <select class="form-control required" name="uso">
                    <option value="">[Seleccione]</option>
                    @foreach($tipos_examen as $examen)
                        <option value="{{$examen->id}}">{{$examen->nombre}}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-lg-6">
            <label for="unidad_medida_id">Unidad de medida</label>
            <select name="unidad_medida_id" class="form-control required">
                <option value="">[Seleccione]</option>
                @foreach($unidades as $unidad)
                    <option {{$unidad->id==$insumo->unidad_medida_id ? 'selected' : '' }} value="{{$unidad->id}}">{{$unidad->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-6">
            <label for="cantidad">Cantidad</label>
            <input readonly class="form-control required input-numeric" name="cantidad" value="{{$insumo->cantidad}}">
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
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Unidad medida</th>
                <th>Estado</th>
                <th>Usuario</th>
                <th>Fecha acción</th>
            </tr>
            </thead>
            <tbody>
            @forelse($insumo->bitacora as $bitacora)
                <tr>
                    <td>{{$bitacora->nombre}}</td>
                    <td>{{$bitacora->descripcion}}</td>
                    <td>{{$bitacora->medida->nombre}}</td>
                    <td>{{$bitacora->estado ? 'ACTIVO' : 'INACTIVO'}}</td>
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
<br>
<br>
