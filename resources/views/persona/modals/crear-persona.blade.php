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
<form id="form-store" action="{{route('persona.crear')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="tipo_persona" value="">
    <div class="row">
        <div class="col-sm-6">
            <a id="btn-registra-empleado" data-tipo="empleado" class="btn btn-block btn-social btn-default btn-registrar-persona">
                <i class="fa fa-user-md"></i> Registrar empleado
            </a>
        </div>
        <div class="col-sm-6">
            <a id="btn-registra-paciente" data-tipo="paciente" class="btn btn-block btn-social btn-default btn-registrar-persona">
                <i class="fa  fa-wheelchair"></i> Registrar paciente
            </a>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-sm-6">
            <label>DNI</label>
            <input type="text" name="numero_documento" class="form-control required input-digits">
        </div>
        <div class="col-sm-6">
            <label>Teléfono</label>
            <input type="number" name="telefono" class="form-control required">
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-sm-12">
            <label>Nombres</label>
            <input type="text" name="nombre" class="form-control required">
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-sm-6">
            <label>Apellido Paterno</label>
            <input type="text" name="apellido_paterno" class="form-control required">
        </div>
        <div class="col-sm-6">
            <label>Apellido Materno</label>
            <input type="text" name="apellido_materno" class="form-control required">
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-sm-12">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control required">
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-sm-6">
            <div class="row col-sm-12"><label>Género</label></div>
            <div class="row col-sm-12">
                <label><input checked name="genero" type="radio" value="M"> Hombre</label>
                <label><input name="genero" type="radio" value="F"> Mujer</label>
            </div>
        </div>
        <div class="col-sm-6">
            <label>Estado civil</label>
            <select class="form-control required"  name="estado_civil">
                <option value="">[Seleccione]</option>
                @foreach($estados as $estado)
                    <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div id="datos-adicionales" class="row" style="margin-top: 15px;"></div>
</form>
<script id="tpl-persona-paciente" type="text/template">
    @include('persona.partials.paciente')
</script>
<script id="tpl-persona-empleado" type="text/template">
    @include('persona.partials.empleado')
</script>
<script>
    $(document).on('click',".btn-registrar-persona",function () {
        $(".btn-registrar-persona").removeClass('selected');
        $(this).addClass('selected');
        if($(this).data('tipo')=='paciente'){
            $("#datos-adicionales").html($("#tpl-persona-paciente").html());
        }else if($(this).data('tipo')=='empleado'){
            $("#datos-adicionales").html($("#tpl-persona-empleado").html());
        }
        $("input[name=tipo_persona]").val($(this).data('tipo'));

    });
</script>
