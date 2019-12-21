@extends('layouts.app')
@section('title','Registar nueva persona')

@section('content')
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
    <div class="row">
        <div style="padding-bottom: 24px" class="text-center">
                <span class="page-header text-info"  style="font-size: 37px; color: #337ab7;">
                    <i class="fa  {{$tipo_persona=='medico' ? 'fa-user-md' : 'fa-stethoscope' }}"></i> Registro de {{$tipo_persona=='medico' ? 'Médico' : 'Paciente'}}
                </span>
        </div>
    </div>
    <div class="row" style="margin-top: 15px">
        <div class="col-sm-1"></div>
        <div id="registros-analisis" class="col-sm-10">
            <div class="panel box">
                <div class="box-header with-border" data-toggle="collapse" href="#" aria-expanded="true">
                    <div class="content-title">
                        <h4 class="box-title">
                            DATOS DEL {{$tipo_persona=='medico' ? 'MÉDICO' : 'PACIENTE'}}
                        </h4>
                    </div>
                    <div class="content-icon">
                    </div>
                </div>
                <div id="collapseContactabilidad" class="panel-collapse collapse in" aria-expanded="true" style="">
                    <div class="box-body">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8">
                            <form id="form-store" action="{{route('persona.crear')}}">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="tipo_persona" value="{{$tipo_persona}}">
                                <div class="row" style="margin-top: 15px;">
                                    <div class="col-sm-6">
                                        <label>DNI</label>
                                        <div class="input-group">
                                            <input type="text"  length="8" maxlength="8" name="numero_documento" class="form-control required input-digits input-reniec">
                                            <span class="input-group-btn">
                                                <button
                                                    id="btn_validar"
                                                    data-btn_registrado='<i class="fa fa-remove"></i> No se puede registrar'
                                                    data-btn_encontrado='<i class="fa fa-check"></i> Validado por reniec'
                                                    data-btn_no_encontrado='<i class="fa fa-remove"></i> No encontrado'
                                                    data-btn_validando='<i class="fa fa-spinner fa-spin"></i> validando'
                                                    data-btn_validar='<i class="fa fa-search"></i> validar'
                                                    type="button" class="btn btn-info btn-flat">
                                                    <i class="fa fa-search"></i> validar
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Teléfono</label>
                                            <input  disabled minlength="6" maxlength="9" type="text" name="telefono" class="form-control required input-digits">
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 15px;">
                                    <div class="col-sm-12">
                                        <label>Nombres</label>
                                        <input disabled type="text" name="nombre" class="form-control required">
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 15px;">
                                    <div class="col-sm-6">
                                        <label>Apellido Paterno</label>
                                        <input disabled type="text" name="apellido_paterno" class="form-control required">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Apellido Materno</label>
                                        <input  disabled type="text" name="apellido_materno" class="form-control required">
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 15px;">
                                    <div class="col-sm-6">
                                        <label>Fecha de nacimiento</label>
                                        <input disabled name="fecha_nacimiento" type="text" class=" dateISO form-control required">
                                    </div>

                                </div>
                                <div class="row" style="margin-top: 15px;">
                                    <div class="col-sm-12">
                                        <label>Dirección</label>
                                        <input disabled type="text" name="direccion" class="form-control required">
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 15px;">
                                    <div class="col-sm-6">
                                        <div class="row col-sm-12"><label>Género</label></div>
                                        <div class="row col-sm-12">
                                            <label><input disabled checked name="genero" type="radio" value="M"> Hombre</label>
                                            <label><input disabled name="genero" type="radio" value="F"> Mujer</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Estado civil</label>
                                        <select disabled class="form-control required"  name="estado_civil">
                                            <option value="">[Seleccione]</option>
                                            @foreach($estados as $estado)
                                                <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="datos-adicionales" class="row" style="margin-top: 15px;">
                                    @if($tipo_persona=='medico')
                                        @include('persona.partials.empleado')
                                        @else
                                        @include('persona.partials.paciente')
                                    @endif
                                </div>
                                <div style="margin-top: 40px;" class="row">
                                    <button disabled id="btn-nuevo" type="button" class="btn btn-success btn-sm pull-right">GUARDAR</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                    <div class="box-footer no-padding">
                        <div class="mailbox-controls">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-"></div>
    </div>
@endsection
@section('scripts')

    <script>
        $(document).ready(function () {
            $('input[name=fecha_nacimiento]').inputmask('yyyy-mm-dd', { 'placeholder': 'aaaa-mm-dd' })
            $(document).on('click',".btn-registrar-persona",function () {
                $(".btn-registrar-persona").removeClass('selected');
                $(this).addClass('selected');
                if($(this).data('tipo')=='paciente'){
                    $("#datos-adicionales").html($("#tpl-persona-paciente").html());
                }else if($(this).data('tipo')=='empleado'){
                    $("#datos-adicionales").html($("#tpl-persona-empleado").html());
                }
                $("input[name=tipo_persona]").val($(this).data('tipo'));
                $(".input-digits").inputFilter(function (value) {
                    return format_digits(value);
                });

            })

            $(document).on('click',"#btn-nuevo",function (e) {

                if($(this).is(":disabled")) return false;

                var form = $("#form-store");

                if(!form.valid()) return false;

                var url = form.attr('action');
                var btn = $(this);
                $.ajax({
                    url : url,
                    type : 'post',
                    data : form.serializeArray(),
                    success: function (message) {
                        toastr["success"](message.message);
                        limpiarFormulario();
                    }
                    ,beforeSend: function () {
                        btn.html("<i class='fa  fa-circle-o-notch fa-spin'> </i> GUARDANDO");
                        btn.attr('disabled',true);
                    }, complete: function () {
                        btn.html('GUARDAR');
                        $("input[name=numero_documento]").val("");
                        $("#btn_validar").html($("#btn_validar").data('btn_validar'));
                    }
                });

            });
            function limpiarFormulario() {
                $("input[name=telefono]").val("");
                $("input[name=nombre]").val("");
                $("input[name=apellido_paterno]").val("");
                $("input[name=apellido_materno]").val("");
                $("select[name=estado_civil]").val("").trigger("change");
                $("select[name=tipo_seguro]").val("").trigger("change");
                $("input[name=numero_historia]").removeAttr('disabled');
                $("input[name=direccion]").val("");

                $("input[name=telefono]").attr('disabled',true);
                $("input[name=nombre]").attr('disabled',true);
                $("input[name=apellido_paterno]").attr('disabled',true);
                $("input[name=apellido_materno]").attr('disabled',true);
                $("input[name=genero]").attr('disabled',true);
                $("select[name=estado_civil]").attr('disabled',true);
                $("select[name=tipo_seguro]").attr('disabled',true);
                $("input[name=numero_historia]").attr('disabled',true);
                $("input[name=direccion]").attr('disabled',true);
                $("input[name=numero_historia]").val("");
                $("input[name=numero_colegiatura]").val("");
                $("input[name=numero_colegiatura]").attr('disabled',true);
                $("input[name=fecha_nacimiento]").val("");
                $("input[name=fecha_nacimiento]").attr('disabled',true);
                $("#btn-nuevo").attr('disabled',true);

            }
            function habilitarFormulario() {
                $("input[name=telefono]").removeAttr('disabled');
                $("input[name=nombre]").removeAttr('disabled');
                $("input[name=apellido_paterno]").removeAttr('disabled');
                $("input[name=apellido_materno]").removeAttr('disabled');
                $("input[name=genero]").removeAttr('disabled');
                $("select[name=estado_civil]").removeAttr('disabled');
                $("select[name=tipo_seguro]").removeAttr('disabled');
                $("input[name=numero_historia]").removeAttr('disabled');
                $("input[name=direccion]").removeAttr('disabled');
                $("input[name=numero_colegiatura]").removeAttr('disabled');
                $("input[name=fecha_nacimiento]").val("");
                $("input[name=fecha_nacimiento]").removeAttr('disabled');
            }

            var url_renic= "{{route('persona.validar','numero_documento')}}";

            $(".input-reniec").keypress(function (e) {
                var value = $(this).val()+ e.key;
                console.log(value);
                var  btn =$("#btn_validar");
                if(format_digits(value)){
                    if(value.length==8){
                        $(this).val(value);
                        var url  = url_renic;
                        url = url.replace('numero_documento',value)
                        $.ajax({
                            url : url,
                            type :'get',
                            success: function (persona) {
                                if(persona.registrado){
                                    toastr["error"]('La persona ya se encuentra registrado');
                                    btn.html(btn.data('btn_registrado'));
                                    return true;
                                }else if(persona.success){
                                    btn.html(btn.data('btn_encontrado'));
                                    habilitarFormulario();
                                    $("input[name=apellido_paterno]").val(persona.apellido_paterno);
                                    $("input[name=apellido_materno]").val(persona.apellido_materno);
                                    $("input[name=nombre]").val(persona.nombres);
                                    $("input[name=direccion]").val(persona.departamento +" - "+ persona.provincia+" - "+persona.distrito);
                                    $("#btn-nuevo").removeAttr('disabled');
                                    toastr["success"]('Se ha validado los datos de la persona en la RENIEC');
                                    return true;
                                }
                                habilitarFormulario();
                                toastr["warning"]('Por favor, asegúrese que el número de documento de identidad sea correcto');
                                $("#btn-nuevo").removeAttr('disabled');
                                btn.html(btn.data('btn_no_encontrado'));

                                return true;
                            }, beforeSend: function () {
                                btn.html(btn.data('btn_validando'));
                                $('input[name=numero_documento]').attr('disabled',true);
                            }, complete: function () {
                                $('input[name=numero_documento]').removeAttr('disabled');
                            }
                        });
                    }else {
                        btn.html(btn.data('btn_validar'));
                        limpiarFormulario();
                    }
                    return true;
                }
                return false;

            });

            $(".input-reniec").keydown(function (e) {
                if(e.which==8){
                    $("#btn_validar").html($("#btn_validar").data('btn_validar'));
                    limpiarFormulario();
                }
            });
        });
    </script>

@endsection


