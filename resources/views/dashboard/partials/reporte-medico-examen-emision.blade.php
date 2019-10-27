<div class="row">
    <div class="col-sm-8">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Exámenes realizados</h3>
            </div>
            <div class="box-body">
                <div id="chartdiv_medico" style="height: 233px; width: 700px;" height="233" width="467"></div>
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
                        <h3>{{round(($analisis->where('estado','PR')->count()/$analisis->count())*100,2)}}%</h3>
                        <p>Exámenes sin resultado</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pie-outline"></i>
                    </div>
                </div>
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{round(($analisis->where('estado','AP')->count()/$analisis->count())*100,2)}}%</h3>
                        <p>Exámenes con resultado</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pie-outline"></i>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>

    </div>
    <div class="col-sm-12">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{$resultados->flatten()->sum('cantidad_sub_tipo')}}</h3>
                <p>Total de exámenes</p>
            </div>
            <div class="icon">
                <i class="ion ion-clipboard"></i>
            </div>
        </div>
    </div>

    <!-- ./col -->
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
            </div>
            <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped" style="font-size:13px;">
                    <thead style="background-color: #3c8dbc; color: white">
                    <tr>
                        <th>Tipo Examen</th>
                        <th>Sub-tipo examen</th>
                        <th>Cantidad</th>

                    </tr>
                    </thead>
                    <tbody>
                        @foreach($resultados as $tipos)
                            @foreach($tipos as $tipo)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{$tipos->count()}}">{{$tipo->examen_tipo}}</td>
                                    @endif
                                    <td>{{$tipo->examen_sub_tipo}}</td>
                                    <td>{{$tipo->cantidad_sub_tipo}}</td>
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

<script>
    am4core.ready(function() {

// Themes begin
        am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
        var chart = am4core.create("chartdiv_medico", am4charts.PieChart);

// Add data

        var data= JSON.parse('{!! json_encode($endPieData) !!}');
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
