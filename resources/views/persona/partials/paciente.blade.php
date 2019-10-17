<div class="col-sm-12">
    <label>Datos adicionales</label>
    <hr style="margin-top: 0px;">
    <div class="col-sm-6">
        <label>Tipo Seguro</label>
        <select name="tipo_seguro" class="form-control required">
            <option value="">[Seleccione]</option>
            @foreach($tipo_seguros as $tipo)
                <option
                    @if(isset($persona))
                        {{optional($persona->paciente)->tipo_seguro_id==$tipo->id ? 'selected' : ''}}
                    @endif
                    value="{{$tipo->id}}">{{$tipo->nombre}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-6">
        <label>Número de Historia Clínica</label>
        <input name="numero_historia"  class="form-control required" value="{{$persona->paciente->numero_historia_clinica ?? ''}}">
    </div>
</div>