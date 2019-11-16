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
                    Reporte stock de insumos
                </span>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-sm-8">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">% Insumos</h3>
                </div>
                <div class="box-body">
                    <div id="chartdiv" style="height: 233px; width: 700px; font-size: 10px; position: relative;" height="233" width="467"></div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-sm-4">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Semaforización</h3>
                </div>
                <div class="box-body">
                    <table class="table">
                        @foreach($semaforizacion as $semafor)
                            <tr>
                                <td style=" width: 120px;background-color: {{$semafor->color}}"></td>
                                <td>{{$semafor->descripcion}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <br>
                <a style="margin-top: 0px;" href="{{route('dashboard.stock-insumo')}}"><i class="fa fa-refresh"></i> Limpiar filtro</a>
            </div>
        </div>
    </div>

    <section id="main-section"  style="padding-top: 0px; background: transparent; border: 0px;">
        <div class="panel box">
            <div class="box-header with-border" data-toggle="collapse" href="#" aria-expanded="true">
                <div class="content-title">
                    <h4 class="box-title">
                        Stock de insumos
                    </h4>

                </div>
                <div class="content-icon">
                    <span class="collapse-icon fa fa-angle-up"></span>
                </div>
            </div>
            <div id="collapseContactabilidad" class="panel-collapse collapse in" aria-expanded="true" style="">
                <div class="box-body">
                    <div class="mailbox-controls">
                        <div class="row">
                            <div class="col-sm-6">
                                <form id="form-search" method="get">
                                    <div style="width: 200px; " class="input-group">
                                        <input value="{{request()->stock}}" name="stock" class="pull-left form-control input-digits" placeholder="Ingrese cantidad">
                                        <span id="btn-buscar" class="btn btn-default input-group-addon"><i class="fa fa-search"></i></span>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-6">
                                <a class="pull-right" id="btn-descargar-reporte" style="padding-top: 10px;" target="_blank" href="{{route('dashboard.download-stock-insumo')}}">
                                    <i class="fa fa-download"></i> Descargar reporte
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped" style="font-size:13px;">
                            <thead style="background-color: #3c8dbc; color: white">
                            <tr>
                                <th>Insumo</th>
                                <th>Cantidad actual</th>
                                <th>Unidad de medida</th>
                                <th>Uso</th>
                                <th>SEMÁFORO</th>
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
                                        <th title="Cantidad {{$uso->cantidad}}" style="background-color: {{$semaforizacion->where('rango_inicio','<=',$uso->cantidad)->where('rango_fin','>=',$uso->cantidad)->first()->color}}"></th>
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
    </section>

@endsection
@section('scripts')
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="{{URL::asset('public/plugins/bootbox/bootbox.min.js')}}"></script>


    <script>

        // Create chart instance


        am4core.ready(function() {


            am4core.useTheme(am4themes_animated);

            var chart = am4core.create("chartdiv", am4charts.PieChart);
            var data= JSON.parse('{!! json_encode($endBarData) !!}');
            data.forEach(function (item) {
                return item.color  =   am4core.color(item.color);
            });
            // Add data
            chart.data =data;
            chart.innerRadius = am4core.percent(50);
            // Add and configure Series
            var pieSeries = chart.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "litres";
            pieSeries.dataFields.category = "country";
            pieSeries.slices.template.propertyFields.fill = "color";
            chart.legend = new am4charts.Legend();
            chart.innerRadius = am4core.percent(50);
            pieSeries.dataFields.value = "litres";
            pieSeries.dataFields.category = "country";
            pieSeries.slices.template.stroke = am4core.color("#fff");
            pieSeries.slices.template.strokeWidth = 2;
            pieSeries.slices.template.strokeOpacity = 1;


            pieSeries.hiddenState.properties.opacity = 1;
            pieSeries.hiddenState.properties.endAngle = -90;
            pieSeries.hiddenState.properties.startAngle = -90;

        }); // end am4core.ready()


        $(document).ready(function () {
            $("#btn-descargar-reporte").click(function (e) {
                e.preventDefault();
                var data = {stock: $("input[name=stock]").val()};

                var url = $(this).attr('href')+"?"+serialiseObject(data);
                window.open(url);
            });

            $("#btn-buscar").click(function () {
                if(!$("input[name=stock]").val()) return false;
                $("#form-search").submit();
            });

            $(document).on('click','#btn-editar-semaforo',function () {
                var url = $(this).data('url');
                $.get(url,function (view) {
                    var dialog = bootbox.dialog({
                        title: "<b>Semaforización</b>",
                        message: view,
                        size: 'large',
                        buttons: {
                            cancel: {
                                label: "CERRAR",
                                className: 'btn btn-sm btn-default',
                                callback: function(){
                                    return true;
                                }
                            },
                            ok:  {
                                label: 'GUARDAR',
                                className: 'btn btn-sm btn-info',
                                callback: function () {
                                    var form = $("#form-store");
                                    if(!form.valid()) return false;
                                    console.log(form.serializeArray());
                                    $.ajax({
                                        url : form.attr('action'),
                                        type :'put',
                                        data: form.serializeArray()
                                        });
                                }
                            }
                        }
                    });
                });
            });
        })
    </script>
@endsection
