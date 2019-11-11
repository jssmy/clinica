<div  class="row">
    <div class="col-sm-12">
        <label> Reporte por profesionales</label>
        <div style="font-size: 8px;" class="text-center" id="chartdiv"></div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive mailbox-messages">
            <table class="table table-hover table-striped" style="font-size:13px;">
                <thead style="background-color: #3c8dbc; color: white">
                <tr>
                    <th>Número documento</th>
                    <th>Nombres</th>
                    <th>Cantidad</th>
                </tr>
                </thead>
                <tbody>
                @foreach($endPersonas as $persona)
                    <tr>
                        <td>{{$persona->numero_documento}}</td>
                        <td>{{$persona->nombre_completo}}</td>
                        <td>{{$persona->cantidad}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Resources -->



<script>
    am4core.ready(function() {

// Themes begin
        am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
        var chart = am4core.create("chartdiv", am4charts.XYChart);

// Add data
        var data= JSON.parse('{!! json_encode($endBarData) !!}');
        console.log(data);
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
        image.propertyFields.href = "bullet";
        image.tooltipText = series.columns.template.tooltipText;
        image.propertyFields.fill = "color";
        image.filters.push(new am4core.DropShadowFilter());

    }); // end am4core.ready()
</script>



