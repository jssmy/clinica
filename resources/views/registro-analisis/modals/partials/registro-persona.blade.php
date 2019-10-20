<div class="col-sm-12">
    <br>
    <label><i class="fa fa-stethoscope"></i>Datos del Paciente</label>
    <hr style="margin-top: 0px;">

        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="paciente_id" value="{{$persona->id}}">
        <div class="row" style="margin-top: 15px;">
            <div class="col-sm-6">
                <label>DNI</label>
                <input type="number" readonly name="numero_documento_paciente" class="form-control required" value="{{$persona->numero_documento}}">
            </div>
            <div class="col-sm-6">
                <label>Número de Historia Clínica</label>
                <input type="number" readonly name="numero_historia_paciente" class="form-control required" value="{{optional($persona->paciente)->numero_historia_clinica}}">
            </div>
        </div>
        <div class="row" style="margin-top: 15px;">
            <div class="col-sm-12">
                <label>Nombres</label>
                <input type="text" readonly name="nombre_paciente" class="form-control required" value="{{$persona->nombre_completo}}">
            </div>
        </div>

</div>
