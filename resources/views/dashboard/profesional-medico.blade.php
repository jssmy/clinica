@extends('layouts.app')
@section('title','Registros')
@section('styles')
    <link rel="stylesheet" href="{{URL::asset('public/bower_components/Ionicons/css/ionicons.min.css')}}">
    <style>
        #chartdiv {
            width: 100%;
            min-height: 60%;
        }

    </style>
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
@endsection
@section('content')
    <input type="hidden" id="tecnologo"value="{{request()->tecnologo ? 'SI' : 'NO'}}" }>
    <section id="search-section" >
        <!-- title row -->
        <div class="row">
            <div style="padding-bottom: 24px" class="text-center">
                <span class="page-header text-info"  style="font-size: 37px; color: #337ab7;">
                    <span class="fa fa-search"></span>
                    @if(request()->tecnologo)
                        Reporte de Profesional de laboratorio
                    @else
                        Reporte de Profesional Médico
                    @endif
                </span>
            </div>
        </div>
        <!-- info row -->
        <div class="row">
            <div style=" display: flex;justify-content: center;">
                    <div style="width: 35%" class="invoice-col">
                        <div class="input-group input-group-sm">
                            <div class="input-group-btn">
                                <button class="btn btn-default" style="color: #fff;background: #31708f;font-size: 14px;">Nro. documento</button>
                            </div>
                            <!-- /btn-group -->
                            <input data-btn="btn-consultar" maxlength="8" id="txt-numero" type="text" name="numero" class="input-submit form-control input-digits" placeholder="número de documento">
                        </div>
                    </div>
                    <div style="width: 35%; margin-left: 15pX;" class="invoice-col">
                        <div class="input-group input-group-sm">
                            <div class="input-group-btn">
                                <button class="btn btn-default" style="color: #fff;background: #31708f;font-size: 14px;">Fecha inicio/Fecha fin</button>
                            </div>
                            <!-- /btn-group -->
                            <input  type="text" name="fecha_registro" class="input-submit form-control input-digits" placeholder="fecha">

                            <div class="input-group-btn">
                                <button id="elimiar-fecha" class="btn btn-default" style="color: #fff;background: #31708f;font-size: 14px;"><i class="fa fa-remove"></i></button>
                            </div>
                        </div>
                    </div>
                    <div style="margin-left: 15pX;" class="invoice-col">
                        <div class="input-group input-group-sm">
                            <div class="input-group-btn">
                                <button id="btn-consultar"
                                        type="button"
                                        class="btn btn-default"
                                        data-url="{{route('persona.dato.personal',['empleado','numero_documento'])}}"
                                        style="color: #fff;background: #31708f;font-size: 14px;"><i class="fa fa-search"></i>Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div style="margin-top: 15px; margin-left: 80px;" class="invoice-col">
                    <a style="margin-top: 30px;" href=""> <i class="fa fa-refresh"></i> Actualizar
                    </a>
                </div>
            </div>
        </div>
        <div id="message">

        </div>

    </section>
    <div id="reporte"  style="padding-top: 20px; background: transparent; border: 0px;">
        @include('dashboard.partials.main-reporte-examen-medico')
    </div>

    <div id="main-section"  style="padding-top: 0px; background: transparent; border: 0px;">

    </div>

@endsection
@section('scripts')

    <script src="{{URL::asset('/public/bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{URL::asset('/public/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{URL::asset('public/plugins/bootbox/bootbox.min.js')}}"></script>
    <script>

        var load_reporte_url="{{route('dashboard.profesional-medico',['persona=persona_id'])}}";
        var load_reporte_medico="{{route('dashboard.profesional-medico-reporte','persona_id')}}";

        $("#elimiar-fecha").click(function () {
            $("input[name=fecha_registro]").val("");
        });
        $('input[name=fecha_registro]').daterangepicker({
            "locale": {
                format: "YYYY-MM-DD",
                "separator": " hasta ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "DE",
                "toLabel": "HASTA",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "Dom",
                    "Lun",
                    "Mar",
                    "Mie",
                    "Jue",
                    "Vie",
                    "Sáb"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            }
        });

        $("input[name=fecha_registro]").val("");
        $("input[name=fecha_registro]").attr('readonly',true);

        $(document).on("click","a", function (e) {
            if($(this).parent().parent().hasClass('pagination')){
                if($(this).hasClass('disabled')) return  false;
                $(this).addClass('disabled');
                load_table($(this).attr('href'));
                return false;
            }

        });

        function load_reporte_medido() {
            var url = $("#btn-consultar").data('url');
            $.ajax({
                url: url,
                type: 'get',
                data: params,
                success: function (view){

                    $("#main-section").html(view);
                    $('#main-section').fadeIn();
                    $('#search-section').fadeOut();
                    $("#reporte").fadeOut();
                    params.persona = JSON.parse($("#hdh-persona").val());
                    load_reporte();

                },
                beforeSend: function(){
                    //btn.html("<i class='fa fa-circle-o-notch fa-spin'></i> Buscando");
                    //btn.attr('disabled', true);
                },
                complete: function(){
                    //btn.html('<span class="fa fa-search" style="color: #fff;background: #31708f;"></span>');
                    //btn.removeAttr('disabled');
                }
            });
        }
        function load_main_table() {
            if($("#tecnologo").val()=="SI") params.tecnologo=true;
            $.ajax({
                url: load_reporte_url,
                type: 'get',
                data: params,
                success: function (view){

                    $("#reporte").html(view);
                    return true;
                    /*
                    $("#main-section").html(view);
                    $('#main-section').fadeIn();
                    $('#search-section').fadeOut();
                    $("#reporte").fadeOut();
                    params.persona = JSON.parse($("#hdh-persona").val());
                    load_reporte();
                    */

                },
                beforeSend: function(){
                    //btn.html("<i class='fa fa-circle-o-notch fa-spin'></i> Buscando");
                    //btn.attr('disabled', true);
                },
                complete: function(){
                    //btn.html('<span class="fa fa-search" style="color: #fff;background: #31708f;"></span>');
                    //btn.removeAttr('disabled');
                }
            });
        }
        var params={};
        $("#btn-consultar").on('click', function (event, data) {
            params. numero_documento = $("#txt-numero").val();
            params.fecha_registro = $("input[name=fecha_registro]").val();

            $('#message').html('');
            var btn = $(this);
            if(!params.numero_documento && params.fecha_registro){
                load_main_table();
            }else {
                load_reporte_medido();
            }

        });

        /* load reporte*/

        function load_reporte(){
            if($("#tecnologo").val()=="SI") params.tecnologo=true;
            var url_temporal =load_reporte_medico;
            $.get(url_temporal.replace('persona_id',params.persona.id),params,function (view) {
                $("#registros-analisis").html(view);
            });
        }
    </script>
@endsection
