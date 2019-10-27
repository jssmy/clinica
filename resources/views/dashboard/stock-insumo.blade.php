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
                    <i class="fa  fa-bar-chart"></i> Reporte stock de insumo
                </span>
            </div>
        </div>
        <!-- info row -->
        <div id="message">

        </div>
    </section>

    <div id="main-section"  style="padding-top: 0px; background: transparent; border: 0px;">
        <div class="panel box">
            <div class="box-header with-border" data-toggle="collapse" href="#" aria-expanded="true">
                <div class="content-title">
                    <h4 class="box-title">
                        Reporte de stock de insumos
                    </h4>

                </div>
                <div class="content-icon">
                    <span class="collapse-icon fa fa-angle-up"></span>
                </div>
            </div>
            <div id="collapseContactabilidad" class="panel-collapse collapse in" aria-expanded="true" style="">
                <div class="box-body">
                    <div class="mailbox-controls">
                    </div>
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped" style="font-size:13px;">
                            <thead style="background-color: #3c8dbc; color: white">
                            <tr>
                                <th>Insumo</th>
                                <th>Cantidad actual</th>
                                <th>Unidad de medida</th>
                                <th>Uso</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($insumos as $insumo => $usos)
                                @foreach($usos as $uso)
                                    <tr>
                                        @if($loop->first)
                                            <td rowspan="{{$usos->count()}}">{{$uso->insumo}}</td>
                                            <td rowspan="{{$usos->count()}}">{{$uso->cantidad}}</td>
                                            <td rowspan="{{$usos->count()}}">{{$uso->unidad}}</td>
                                        @endif
                                        <td>{{$uso->uso}}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
                <div class="box-footer no-padding">
                    <div class="mailbox-controls">

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
@section('scripts')

    <script src="{{URL::asset('public/plugins/bootbox/bootbox.min.js')}}"></script>
    <script>


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
