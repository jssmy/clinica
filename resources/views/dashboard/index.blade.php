@extends('layouts.app')
@section('title','Registros')
@section('styles')
    <link rel="stylesheet" href="{{URL::asset('public/bower_components/Ionicons/css/ionicons.min.css')}}">
@endsection
@section('content')

    <section id="search-section" >
        <!-- title row -->
        <div class="row">
            <div style="padding-bottom: 24px" class="text-center">
                <span class="page-header text-info"  style="font-size: 37px; color: #337ab7;">
                    Reportes
                </span>
            </div>
        </div>
        <!-- info row -->
        <div class="row">
            <div style=" display: flex; justify-content: center;">
                <div style="min-width: 300px; width: 50%" class="invoice-col">
                    <div class="input-group input-group-lg">
                        <div class="input-group-btn">
                            <button class="btn btn-default" style="color: #fff;background: #31708f;font-size: 14px;">Nro. documento</button>
                        </div>
                        <!-- /btn-group -->
                        <input data-btn="btn-consultar" id="txt-numero" type="text" name="numero" class="input-submit form-control input-digits" placeholder="buscar">
                        <div class="input-group-btn">
                            <button id="btn-consultar"
                                    data-search="<span class='fa fa-search' style='color: #fff;background: #31708f;'></span>"
                                    data-loading="<i class='fa fa-circle-o-notch fa-spin'></i> Buscando"
                                    class="btn btn-default"
                                    data-tipo_persona="{{$tipo_reporte}}"
                                    data-url="{{route('persona.dato.personal',$tipo_persona)}}"
                                    title="buscar..." style="color: #fff;background: #31708f; font-size: 15px">
                                <span class="fa fa-search" style="color: #fff;background: #31708f;"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <div id="message">

        </div>

    </section>
    <div id="reporte"  style="padding-top: 0px; background: transparent; border: 0px;">
        @if($tipo_persona=='empleado')
            @include('dashboard.partials.main-reporte-examen-medico')
        @endif
    </div>

    <div id="main-section"  style="padding-top: 0px; background: transparent; border: 0px;">

    </div>

@endsection
@section('scripts')
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="{{URL::asset('public/plugins/bootbox/bootbox.min.js')}}"></script>
    <script>
        var load_reporte_url="{{route('dashboard.mostrar-reporte',['persona_id',$tipo_reporte])}}";

        $(document).on("click","a", function (e) {
            if($(this).parent().parent().hasClass('pagination')){
                if($(this).hasClass('disabled')) return  false;
                $(this).addClass('disabled');
                load_table($(this).attr('href'));
                return false;
            }

        });

        var params={};
        $("#btn-consultar").on('click', function (event, data) {

            if ($("#txt-numero").val() == ""){
                return false;
            }
            var url = $(this).data('url');
            $('#message').html('');
            var btn = $(this);
            params.numero_documento = $("#txt-numero").val();
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
                    btn.html("<i class='fa fa-circle-o-notch fa-spin'></i> Buscando");
                    btn.attr('disabled', true);
                },
                complete: function(){
                    btn.html('<span class="fa fa-search" style="color: #fff;background: #31708f;"></span>');
                    btn.removeAttr('disabled');
                }
            });
        });

        /* load reporte*/
        function load_reporte(){
            var url_temporal =load_reporte_url.replace('persona_id',params.persona.id);
            $.get(url_temporal,function (view) {
                $("#registros-analisis").html(view);
            });
        }
    </script>
@endsection
