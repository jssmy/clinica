@extends('layouts.app')
@section('title','Registros')
@section('styles')
    <link rel="stylesheet" href="{{URL::asset('public/bower_components/Ionicons/css/ionicons.min.css')}}">

    <style>
        #chartdiv {
            width: 100%;
            height: 300px;
        }

    </style>
@endsection
@section('content')
    <section id="search-section" >
        <!-- title row -->
        <div class="row">
            <div style="padding-bottom: 24px" class="text-center">
                <span class="page-header text-info"  style="font-size: 37px; color: #337ab7;">
                    <span class="fa fa-medkit"></span>
                    Reporte de patologías anormales
                </span>
            </div>
        </div>
        <!-- info row -->
    </section>
    <div class="row">
        <div class="col-md-3">
            <button id="btn-consultar" class="btn btn-warning btn-block margin-bottom">Buscar</button>

            <div class="box box-solid" style="height: 300px;">
                <div class="box-header with-border">
                    <h3 class="box-title">Filtros</h3>
                </div>
                <div  class="box-body no-padding">
                    <form id="form-search">
                        <ul class="nav nav-pills nav-stacked" style="padding-top: 15px;">
                            <li><input  name="numero_documento" style="margin-top: 10px; margin-left: 5px; width: 90%" class="form-control input-digits" placeholder="Número de DNI"></li>
                            <li><input  name="fecha_resultado" style="margin-top: 10px; margin-left: 5px; width: 90%;" class="form-control input-digits required" placeholder="Fecha inicio - Fecha fin"></li>
                        </ul>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <button id="btn-limpiar" class="btn btn-default btn-block margin-bottom">Limpiar</button>
            <!-- /. box -->
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="panel box">
                <div id="collapseContactabilidad" class="panel-collapse collapse in" aria-expanded="true" style="">
                    <div class="box-body">
                        <div class="mailbox-controls">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a id="btn-descargar" class="pull-right"  style="padding-top: 10px;" href="#">
                                        <i class="fa fa-download"></i> Descargar reporte
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped" style="font-size:12px;">
                                <thead style="background-color: #3c8dbc; color: white">
                                <tr>
                                    <th style="width: 120px;">Cód. registro</th>
                                    <th style="width: 150px;">Nombre del paciente</th>
                                    <th>Tipo de examen</th>
                                    <th>Sub-tipo de examen</th>
                                    <th>Resultado</th>
                                    <th style="width: 250px;">Observación</th>
                                </tr>
                                </thead>
                                <tbody data-empty='<tr><td colspan="6" class="text-center">No hay registros para mostrar</td></tr>' id="registros-body">
                                <tr>
                                    @include('dashboard.partials.reporte-patologia-anormal-table')
                                </tbody>
                            </table>
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
    </div>
@endsection
@section('scripts')
    <script src="{{URL::asset('/public/bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{URL::asset('/public/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('input[name=fecha_resultado]').daterangepicker({
                autoUpdateInput: false,
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

            var url_search = "{{route('dashboard.patologia-anormal')}}";
            $("#btn-consultar").on('click',function () {

                $.ajax({
                    url : url_search,
                    type: 'get',
                    data: $("#form-search").serialize(),
                    success: function (view) {

                        $("#registros-body").html(view);
                    }
                });
            });

            $("#btn-limpiar").click(function () {
                $("input[name=numero_documento]").val("");
                $("input[name=fecha_resultado]").val("")
                $("#fecha_registro").val("");
                $("#btn-consultar").trigger('click');
            });
            $(document).on('click',".cancelBtn",function () {
                $("input[name=fecha_resultado]").val("")
            });
            $(document).on('click','.applyBtn',function () {
                $("input[name=daterangepicker_start]").val();
                $("input[name=daterangepicker_end]").val();
                $("input[name=fecha_resultado]").val($("input[name=daterangepicker_start]").val() + " hasta "+$("input[name=daterangepicker_end]").val());
            });

            var url_download="{{route('dashboard.download-patologia-anormal')}}";
            $("#btn-descargar").click(function () {

                window.open(url_download+"?download=true&"+$("#form-search").serialize());
            });
        });
    </script>
@endsection
