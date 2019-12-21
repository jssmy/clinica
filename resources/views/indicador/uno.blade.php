@extends('layouts.app')
@section('title','Indicador uno')
@section('styles')
    <link rel="stylesheet" href="{{URL::asset('public/bower_components/Ionicons/css/ionicons.min.css')}}">
@endsection
@section('content')
    <section id="search-section">
        <!-- title row -->
        <div class="row">
            <div style="padding-bottom: 24px" class="text-center">
                <span class="page-header text-info"  style="font-size: 37px; color: #337ab7;">
                    <span class="fa  fa-hourglass-3"></span>
                   Indicador 1: Tiempo promedio de atención
                </span>
            </div>
        </div>
        <!-- info row -->
    </section>
    <section class="row">
        <!-- /.col -->
        <div class="col-md-4">
            <div class="panel box">
                <div id="collapseContactabilidad" class="panel-collapse collapse in" aria-expanded="true" style="">
                    <div class="box-body">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h2>TP = Σ (Tf - Ti) / NP</h2>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-pie-outline"></i>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <p>Tf: Tiempo final</p>
                        <p>Ti: Tiempo inicial</p>
                        <p>NP: Número de registros con resultados</p>
                        <p>TP: tiempo promedio en minutos</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel box">
                <div id="collapseContactabilidad" class="panel-collapse collapse in" aria-expanded="true" style="">
                    <div class="box-body">
                        <div class="mailbox-controls">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form action="{{route('indicador.uno')}}" id="form-search" method="get">
                                        <div style="width: 200px; " class="input-group pull-right">
                                            <input readonly value="" name="fecha_resultado" class="pull-left form-control input-digits" placeholder="Fecha desde - hasta">
                                            <span id="btn-buscar" class="btn btn-default input-group-addon"><i class="fa fa-search"></i></span>
                                        </div>
                                        <label class="pull-right">Fecha desde - hasta</label>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="table-resultados" class="table-responsive mailbox-messages">
                                @include('indicador.partials.resultado-uno')
                                <!-- /.table -->
                        </div>
                    </div>
                    <div class="box-footer no-padding">
                        <div class="mailbox-controls">

                        </div>
                    </div>
                </div>
            </div>

            <!-- /. box -->
        </div>
        <!-- /.col -->
    </section>
@endsection
@section('scripts')
    <script src="{{URL::asset('public/bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{URL::asset('public/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{URL::asset('public/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>


    <script>
        $("input[name=fecha_resultado]").daterangepicker(
            {
                ranges   : {
                    'Hoy'       : [moment(), moment()],
                    'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
                    'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
                    'Anterior mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate  : moment(),
                locale: {
                    format: 'DD/MM/YYYY',
                    applyLabel : 'Aplicar',
                    cancelable: 'Cancelar',
                    fromLabel : 'desde',
                    toLabel : 'hasta',
                    customRangeLabel : 'Personalizar',
                    daysOfWeek: [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"],
                    monthNames: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Setiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                },

            },
            function (start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        );

        $("#btn-buscar").click(function () {
            var form = $("#form-search");
            $.ajax({
                url : form.attr('action'),
                data: form.serializeArray(),
                type: 'get',
                success: function (view) {
                    $("#table-resultados").html(view);
                }
            });
        });
    </script>
@endsection
