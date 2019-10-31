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
                            <li><input  name="numero_documento" style="margin-top: 10px; margin-left: 5px; width: 90%" class="form-control required input-digits" placeholder="Número de DNI"></li>
                            <li><input  name="fecha_resultado" style="margin-top: 10px; margin-left: 5px; width: 90%;" class="form-control required input-digits" placeholder="Fecha inicio - Fecha fin"></li>
                        </ul>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <button class="btn btn-default btn-block margin-bottom">Limpiar</button>
            <!-- /. box -->
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped" style="font-size:12px;">
                    <thead style="background-color: #3c8dbc; color: white">
                    <tr>
                        <th>Cód. registro</th>
                        <th>Nombre del paciente</th>
                        <th>Tipo de examen</th>
                        <th>Sub-tipo de examen</th>
                        <th>Resultado</th>
                        <th>Observación</th>
                    </tr>
                    </thead>
                    <tbody id="registros-body">
                        <tr><td colspan="6" class="text-center">No hay registros para mostrar</td></tr>
                    </tbody>
                </table>
                <!-- /.table -->
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
                autoUpdateInput: true,
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
                if(!$("#form-search").valid()) return false;
                $.ajax({
                    url : url_search,
                    type: 'get',
                    data: $("#form-search").serialize(),
                    success: function (view) {

                        $("#registros-body").html(view);
                    }
                });
            });
        });
    </script>
@endsection
