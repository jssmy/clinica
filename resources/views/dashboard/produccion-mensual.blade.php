@extends('layouts.app')
@section('title','Registros')
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
                    Reporte de Producción Mensual
                </span>
            </div>
        </div>
        <!-- info row -->
    </section>
    <div class="row">
        <div class="col-md-3">
            <button id="btn-consultar" class="btn btn-warning btn-block margin-bottom">Buscar</button>
            <div class="box box-solid" style="height: 200px;">
                <div class="box-header with-border">
                    <h3 class="box-title">Filtros</h3>
                </div>
                <div  class="box-body no-padding">
                    <form id="form-search">
                        <ul class="nav nav-pills nav-stacked" style="padding-top: 15px;">
                            <li><select name="tipo_examen" class="form-control">
                                    <option value="">[Seleccione]</option>
                                    @foreach($examenes  as $examen)
                                        <option value="{{$examen->id}}">{{$examen->nombre}}</option>
                                    @endforeach
                                </select></li>
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
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped" style="font-size:12px;">
                                    <thead style="background-color: #3c8dbc; color: white">
                                    <tr>
                                        <th style="width: 120px;">Mes</th>
                                        <th>Tipo de examen</th>
                                        <th>Sub-tipo de examen</th>
                                        <th>Pagantes</th>
                                        <th>SIS</th>
                                    </tr>
                                    </thead>
                                    <tbody data-empty='<tr><td colspan="5" class="text-center">No hay registros para mostrar</td></tr>' id="registros-body">
                                        @include('dashboard.partials.reporte-produccion-mensual')
                                    </tbody>
                                </table>
                                <!-- /.table -->
                            </div>
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
            var url_search = "{{route('dashboard.produccion-mensual')}}";

            $('input[name=fecha_registro]').daterangepicker({
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

        $("#btn-limpiar").click(function () {
            $("input[name=numero_documento_paciente]").val("");
            $("input[name=numero_documento_medico]").val("");
            $("input[name=fecha_registro]").val("")
            $("select[name=tipo_examen]").val("").trigger('change');
            $("#btn-consultar").trigger('click')
            $("#registros-body").html($("#registros-body").data('empty'));
        });
        $(document).on('click',".cancelBtn",function () {
            $("input[name=fecha_registro]").val("")
        });
        $(document).on('click','.applyBtn',function () {
            $("input[name=daterangepicker_start]").val();
            $("input[name=daterangepicker_end]").val();
            $("input[name=fecha_registro]").val($("input[name=daterangepicker_start]").val() + " hasta "+$("input[name=daterangepicker_end]").val());
        });
        var url_download="{{route('dashboard.download-produccion-mensual')}}";
        $("#btn-descargar").click(function () {
            if(!$("#form-search").valid()) return false;
            window.open(url_download+"?download=true&"+$("#form-search").serialize());
        });

    </script>
@endsection
