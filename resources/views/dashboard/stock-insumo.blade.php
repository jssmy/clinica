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
    <section class="text-center">
        <div style="width: 20%" class="panel box";>
            <label>Semaforización</label>
            <table class="table">
                <tr>
                    <td  style="background-color: green; width: 30px;"></td>
                    <td  style="background-color: yellow; width: 30px;"></td>
                    <td  style="background-color: red; width: 30px;"></td>
                </tr>
                <tr>
                    <td >250 a más</td>
                    <td >101 - 249</td>
                    <td >0 - 100</td>
                </tr>
            </table>
            <hr style="margin-bottom: 0px;">
            <a style="margin-top: 0px;" href="{{route('dashboard.stock-insumo')}}">Limpiar filtro</a>
        </div>
    </section>
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
                                <a class="pull-right"  style="padding-top: 10px;" target="_blank" href="{{route('dashboard.stock-insumo','download=true')}}">
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
                                        <th style="background-color:
                                        @if($uso->cantidad>=0 && $uso->cantidad<=100)
                                            {{'red'}}
                                        @elseif($uso->cantidad>=101 && $uso->cantidad<=249)
                                            {{'yellow'}}
                                        @else
                                            {{'green'}}
                                        @endif
                                        "></th>
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
        am4core.ready(function() {

// Themes begin
            am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
            var chart = am4core.create("chartdiv", am4charts.XYChart);

// Add data
            var data= JSON.parse('{!! json_encode($endBarData) !!}');
            data.map(function (element) {
                return element.color =chart.colors.next();
            });

            chart.data = data;

// Create axes
            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "name";
            //categoryAxis.renderer.grid.template.disabled = true;
            categoryAxis.renderer.minGridDistance = 30;
            //categoryAxis.renderer.inside = true;
            categoryAxis.renderer.outside = false;
            categoryAxis.renderer.labels.template.fill = am4core.color("#0a0a0a");
            categoryAxis.renderer.labels.template.fontSize = 10;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.renderer.grid.template.strokeDasharray = "4,4";
            //valueAxis.renderer.labels.template.disabled = true;
            valueAxis.min = 0;

// Do not crop bullets
            chart.maskBullets = false;

// Remove padding
            chart.paddingBottom = 0;

// Create series
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueY = "points";
            series.dataFields.categoryX = "name";
            series.columns.template.propertyFields.fill = "color";
            series.columns.template.propertyFields.stroke = "color";
            //series.columns.template.column.cornerRadiusTopLeft = 50;
            //series.columns.template.column.cornerRadiusTopRight = 50;
            series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/b]";

// Add bullets
            var bullet = series.bullets.push(new am4charts.Bullet());
            var image = bullet.createChild(am4core.Image);
            image.horizontalCenter = "middle";
            image.verticalCenter = "bottom";
            image.dy = 10;
            image.y = am4core.percent(60);
            //image.propertyFields.href = "bullet";
            image.tooltipText = series.columns.template.tooltipText;
            image.propertyFields.fill = "color";
            image.filters.push(new am4core.DropShadowFilter());

        }); // end am4core.ready()
        $(document).ready(function () {
            $("#btn-buscar").click(function () {
                if(!$("input[name=stock]").val()) return false;
                $("#form-search").submit();
            });
        })
    </script>
@endsection
