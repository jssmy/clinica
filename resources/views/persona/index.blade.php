@extends('layouts.app')
@section('title','Personas')
@section('content')
    <section id="search-section" >
        <!-- title row -->

        <div class="row">
            <div style="padding-bottom: 24px" class="text-center">
                <span class="page-header text-info"  style="font-size: 37px; color: #337ab7;">
                    <i class="fa fa-plus"></i> Registro de persona
                </span>
            </div>
        </div>
        <!-- info row -->
        <div class="row">
            <div style=" display: flex; justify-content: center;">
                <div style="min-width: 300px; width: 50%" class="invoice-col">
                    <div class="input-group input-group-lg">
                        <div class="input-group-btn">
                            <select id="tipo_persona" class="btn btn-default" style="color: #fff;background: #31708f;font-size: 14px;" >
                                <option value="paciente">Paciente</option>
                                <option value="medico">Médico</option>
                            </select>
                            <!--
                            <button >Nro. documento</button>
                            -->
                        </div>
                        <!-- /btn-group -->
                        <input data-btn="btn-consultar" id="txt-numero" type="text" name="numero" class="input-submit form-control input-digits" placeholder="buscar persona">
                        <div class="input-group-btn">
                            <button id="btn-consultar"
                                    data-search="<span class='fa fa-search' style='color: #fff;background: #31708f;'></span>"
                                    data-loading="<i class='fa fa-circle-o-notch fa-spin'></i> Buscando"
                                    class="btn btn-default"
                                    data-url="{{route('persona.dato.personal','persona_id')}}"
                                    title="buscar..." style="color: #fff;background: #31708f; font-size: 15px">
                                <span class="fa fa-search" style="color: #fff;background: #31708f;"></span>
                            </button>
                        </div>
                    </div>
                    <div style="margin-top: 15px;">
                        <a style="margin-top: 30px;" href="{{route('persona.crear-form','paciente')}}"  > <i class="fa fa-stethoscope"></i> Registrar nueva paciente
                        </a>
                        <a style="margin-top: 30px; margin-left: 15px;" href="{{route('persona.crear-form','medico')}}"  > <i class="fa fa-user-md"></i> Registrar nueva médico
                        </a>
                    </div>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <div id="message">

        </div>
    </section>

    <div id="main-section"  style="padding-top: 0px; background: transparent; border: 0px;">

    </div>
@endsection
@section('scripts')
    <script src="{{URL::asset('public/plugins/bootbox/bootbox.min.js')}}"></script>
    <script>
        var url_index ="{{route('persona.index')}}";

        var params={};
        $(document).on('click','#btn-consultar', function () {
            if ($("#txt-numero").val() == ""){
                return false;
            }
            var url = $(this).data('url');
            url = url.replace('persona_id',$("#tipo_persona").val());
            $('#message').html('');
            var btn = $(this);
            params.numero_documento = $("#txt-numero").val();
            params.section='edit_persona';
            params.buscar_numero_documento=true;
            $.ajax({
                url: url,
                type: 'get',
                data: params,
                success: function (view){
                    $("#main-section").html(view);
                    $('#main-section').fadeIn();
                    $('#search-section').fadeOut();
                    params.persona = JSON.parse($("#hdh-persona").val());
                },
                beforeSend: function(){
                    btn.html("<i class='fa fa-circle-o-notch fa-spin'></i> Buscando");
                    btn.attr('disabled', true);
                },
                complete: function(){
                    btn.html('<span class="fa fa-search" style="color: #fff;background: #31708f;"></span>');
                    btn.removeAttr('disabled');
                }
            });
        });

    </script>
@endsection
