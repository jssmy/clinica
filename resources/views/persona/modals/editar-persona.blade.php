<style>
    .selected{
        background-color: #3c8dbc;
        color: white;
    }
    .selected:hover{
        background-color: #3c8dbc;
        color: white;
    }
</style>
<form id="form-update" action="{{route('persona.editar',$persona)}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="tipo_persona" value="">

    <div class="row" style="margin-top: 15px;">
        <div class="col-sm-6">
            <label>DNI</label>
            <input type="number" name="numero_documento" class="form-control required" value="{{$persona->numero_documento}}">
        </div>
        <div class="col-sm-6">
            <label>Teléfono</label>
            <input type="number" name="telefono" class="form-control required" value="{{$persona->telefono}}">
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-sm-12">
            <label>Nombres</label>
            <input type="text" name="nombre" class="form-control required" value="{{$persona->nombre}}">
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-sm-6">
            <label>Apellido Paterno</label>
            <input type="text" name="apellido_paterno" class="form-control required" value="{{$persona->apellido_paterno}}">
        </div>
        <div class="col-sm-6">
            <label>Apellido Materno</label>
            <input type="text" name="apellido_materno" class="form-control required" value="{{$persona->apellido_materno}}">
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-sm-12">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control required" value="{{$persona->direccion}}">
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-sm-6">
            <div class="row col-sm-12"><label>Género</label></div>
            <div class="row col-sm-12">
                <label><input {{$persona->es_hombre ? 'checked' : ''}} name="genero" type="radio" value="M"> Hombre</label>
                <label><input {{!$persona->es_hombre ? 'checked' : ''}} name="genero" type="radio" value="F"> Mujer</label>
            </div>
        </div>
        <div class="col-sm-6">
            <label>Estado civil</label>
            <select class="form-control required"  name="estado_civil">
                <option value="">[Seleccione]</option>
                @foreach($estados as $estado)
                    <option {{$persona->estado_civil_id==$estado->id  ? 'selected' : ''}} value="{{$estado->id}}">{{$estado->nombre}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div id="datos-adicionales" class="row" style="margin-top: 15px;">
        @includeWhen($persona->es_paciente,'persona.partials.paciente')
        @includeWhen(!$persona->es_paciente,'persona.partials.empleado')
    </div>
</form>

