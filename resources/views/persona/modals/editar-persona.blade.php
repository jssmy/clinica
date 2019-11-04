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
                        <i class="fa {{$tipo_persona=='empleado' ? 'fa-user-md' : 'fa-stethoscope'}}"></i> Actualización de datos del {{$tipo_persona=='empleado' ? 'Médico' : 'Paciente'}}
                </span>
        </div>
    </div>
    <br>
    <div class="row" style="margin-top: 15px">
        <div class="col-sm-1"></div>
        <div id="registros-analisis" class="col-sm-10">
            <div class="panel box">
                <div class="box-header with-border" data-toggle="collapse" href="#" aria-expanded="true">
                    <div class="content-title">
                        <h4 class="box-title">
                            DATOS DEL {{$tipo_persona=='empleado' ? 'MÉDICO' : 'PACIENTE'}}
                        </h4>
                    </div>
                    <div class="content-icon">
                    </div>
                </div>
                <div id="collapseContactabilidad" class="panel-collapse collapse in" aria-expanded="true" style="">
                    <div class="box-body">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8">
                            <form id="form-store" action="{{route('persona.editar',$persona)}}" method="put">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="tipo_persona" value="{{$tipo_persona}}">
                                <div class="row" style="margin-top: 15px;">
                                    <div class="col-sm-6">
                                        <label>DNI</label>
                                        <input length="8" readonly type="text" name="numero_documento" class="form-control required input-digits" value="{{$persona->numero_documento}}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Teléfono</label>
                                        <input minlength="6" maxlength="9"  type="text" name="telefono" class="form-control required input-digits" value="{{$persona->telefono}}">
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
                                    <div class="col-sm-6">
                                        <label>Fecha de nacimiento</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input name="fecha_nacimiento" type="text" class="form-control" value="{{$persona->fec_nacimiento->format('Y-m-d')}}">
                                        </div>
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
                                            <label><input {{$persona->genero=='M' ? 'checked' : ''}}  name="genero" type="radio" value="M"> Hombre</label>
                                            <label><input {{$persona->genero=='F' ? 'checked' : ''}}  name="genero" type="radio" value="F"> Mujer</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Estado civil</label>
                                        <select class="form-control required"  name="estado_civil">
                                            <option value="">[Seleccione]</option>
                                            @foreach($estados as $estado)
                                                <option {{$persona->estado_civil_id==$estado->id ? 'selected' : '' }} value="{{$estado->id}}">{{$estado->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="datos-adicionales" class="row" style="margin-top: 15px;">
                                    @if($tipo_persona=='empleado')
                                        @include('persona.partials.empleado')
                                    @else
                                        @include('persona.partials.paciente')
                                    @endif
                                </div>
                                <div style="margin-top: 40px;" class="row">
                                    <button id="btn-nuevo" type="button" class="btn btn-success btn-sm pull-right">GUARDAR</button>
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
    </div>P
@endsection
@section('scripts')

    <script>
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
                type : 'put',
                data : form.serializeArray(),
                success: function (message) {
                    toastr["success"](message.message);
                }
                ,beforeSend: function () {
                    btn.html("<i class='fa  fa-circle-o-notch fa-spin'> </i> GUARDANDO");
                    btn.attr('disabled',true);
                }, complete: function () {
                    btn.html('GUARDAR');
                    btn.removeAttr('disabled');
                }
            });


        });
        function limpiarFormulario() {
            $("input[name=numero_documento]").val('');
            $("input[name=telefono]").val('');
            $("input[name=nombre]").val('');
            $("input[name=apellido_paterno]").val('');
            $("input[name=apellido_materno]").val('');
            $("select[name=estado_civil]").val('').trigger('change');
            $("input[name=numero_colegiatura]").val('').trigger('change');
            $("select[name=tipo_seguro]").val('').trigger('change');
            $("input[name=numero_historia]").val('').trigger('change');
            $("input[name=direccion]").val('');
        }
    </script>
@endsection


