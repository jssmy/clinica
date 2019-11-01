<div class="col-sm-12">
    <label>Datos adicionales</label>
    <hr style="margin-top: 0px;">
    <div class="col-sm-6">
        <label>Tipo Seguro</label>
        <select  {{ !isset($persona) ? 'disabled' : '' }} name="tipo_seguro" class="form-control required">
            <option value="">[Seleccione]</option>
            @foreach($tipo_seguros as $tipo)
                <option
                    @if(isset($persona))
                        @if($persona->paciente)
                            {{$persona->paciente->tipo_seguro_id==$tipo->id ? 'selected' : ''}}
                        @endif
                    @endif
                    value="{{$tipo->id}}">{{$tipo->nombre}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-6">
        <label>Número de Historia Clínica</label>
        <input  {{ !isset($persona) ? 'disabled' : '' }} name="numero_historia"  type="text" class="form-control required input-digits" value="{{isset($persona) ? ($persona->paciente? $persona->paciente->numero_historia_clinica : '') : ''}}">
    </div>
</div>
