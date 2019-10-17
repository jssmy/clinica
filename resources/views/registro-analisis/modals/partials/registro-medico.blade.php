<div class="col-sm-12">
    <br>
    <label>Datos del Médico</label>
    <hr style="margin-top: 0px;">
    <form id="form-update" action="{{route('persona.editar',$persona)}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="tipo_persona" value="">
        <div class="row" style="margin-top: 15px;">
            <div class="col-sm-6">
                <label>DNI</label>
                <input type="number" readonly name="numero_documento" class="form-control" value="{{$persona->numero_documento}}">
            </div>
            <div class="col-sm-6">
                <label>Número de  Colegiatura</label>
                <input type="number" readonly name="numero_colegiatura" class="form-control required" value="{{optional($persona->empleado)->numero_colegiatura}}">
            </div>
        </div>
        <div class="row" style="margin-top: 15px;">
            <div class="col-sm-12">
                <label>Nombres</label>
                <input type="text" readonly name="nombre" class="form-control required" value="{{$persona->nombre_completo}}">
            </div>
        </div>
        <div class="row" style="margin-top: 15px;">
            <div class="col-sm-6">
                <label>Apellido Paterno</label>
                <input type="text" readonly name="apellido_paterno" class="form-control required" value="{{$persona->apellido_paterno}}">
            </div>
            <div class="col-sm-6">
                <label>Apellido Materno</label>
                <input type="text" readonly name="apellido_materno" class="form-control required" value="{{$persona->apellido_materno}}">
            </div>
        </div>

    </form>
    <br>
    <br>
    <br>
</div>
