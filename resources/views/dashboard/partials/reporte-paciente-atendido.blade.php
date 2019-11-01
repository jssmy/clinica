<div class="row">
    <div class="col-sm-8">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Exámenes realizados</h3>
            </div>
            <div class="box-body">
                <div  id="chartdiv" style="height: 233px; width: 700px; font-size: 10px;" height="233" width="467"></div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-sm-4">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Estado de exámenes</h3>
            </div>
            <div class="box-body">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>@if($allAnalisis->count())
                                {{round($allAnalisis->where('estado','PR')->count()/$allAnalisis->count(),2)*100}}
                            @else
                                0
                            @endif
                            %
                        </h3>
                        <p>Exámenes sin resultados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pie-outline"></i>
                    </div>
                </div>
                <div style="margin-bottom: 0px;" class="small-box bg-teal-active">
                    <div class="inner">
                        <h3>@if($allAnalisis->count())
                                {{round($allAnalisis->where('estado','AP')->count()/$allAnalisis->count(),2)*100}}
                        @else
                                0
                        @endif
                        %
                        </h3>
                        <p>Exámenes con resultados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pie-outline"></i>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>

    </div>
</div>
<div class="panel box">
    <div class="box-header with-border" data-toggle="collapse" href="#" aria-expanded="true">
        <div class="content-title">
            <h4 class="box-title">
                Reporte del paciente atendido
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
                    <div class="col-sm-12">
                        <a class="pull-right"  style="padding-top: 10px;" target="_blank" href="{{route('dashboard.mostrar-reporte',[$persona,$tipo_reporte,'download=true'])}}">
                            <i class="fa fa-download"></i> Descargar reporte
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped" style="font-size:13px;">
                    <thead style="background-color: #3c8dbc; color: white">
                    <tr>
                        <th>Tipo Examen</th>
                        <th>Sub-tipo examen</th>
                        <th>Fecha resultado</th>
                        <th>Resultado</th>

                    </tr>
                    </thead>
                    <tbody>
                        @foreach($analisis as $tipo_examen => $sub_tipos)
                                @foreach($sub_tipos as $sub_tipo_examen => $resultados)
                                    <tr>
                                        @if($loop->first)
                                            <td rowspan="{{$sub_tipos->flatten()->count()}}">{{$tipo_examen}} </td>
                                        @endif
                                        @foreach($resultados as $resultado)
                                            @if($loop->first)
                                                <td rowspan="{{$resultados->count()}}">{{$sub_tipo_examen}}</td>
                                            @endif
                                                @if($resultado->resultado)
                                                    <td>{{$resultado->fecha_resultado}}</td>
                                                    <td>{{$resultado->resultado}}</td>
                                                @else
                                                    <td colspan="2" class="text-center"><label style="width: 80px;" class="label label-warning">SIN RESULTADO</label></td>
                                                @endif

                                            </tr>
                                        @endforeach

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
<script>
    am4core.ready(function() {

// Themes begin
        am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
        var chart = am4core.create("chartdiv", am4charts.PieChart);

// Add data
        var data= JSON.parse('{!! json_encode($endDataPie) !!}');
        chart.data = data;

// Set inner radius
        chart.innerRadius = am4core.percent(50);

// Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "litres";
        pieSeries.dataFields.category = "country";
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeWidth = 2;
        pieSeries.slices.template.strokeOpacity = 1;

// This creates initial animation
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;

    }); // end am4core.ready()
</script>
