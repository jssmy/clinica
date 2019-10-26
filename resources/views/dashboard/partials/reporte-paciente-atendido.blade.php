<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$analisis->count()}}</h3>
                <p>Análisis registrados</p>
            </div>
            <div class="icon">
                <i class="ion ion-clipboard"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                @php
                    $examenes = 0;
                    $analisis->each(function ($examen) use (&$examenes){ $examenes+=$examen->resultados->unique('tipoExamen')->count();});
                @endphp
                <h3>{{$examenes}}</h3>
                <p>Exámenes realizados</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-medkit-outline"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{$analisis->pluck('resultados')->flatten()->pluck('subTipoExamen')->count()}}</h3>
                <p>Sub-tipos de exámenes realizados</p>
            </div>
            <div class="icon">
                <i class="ion ion-thermometer"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{round($analisis->pluck('resultados')->flatten()->avg('resultado'),2)}}</h3>
                <p>Resultado promedio</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-pie"></i>
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
                        <th>Código</th>
                        <th>Tipo Examen</th>
                        <th>Sub-tipo examen</th>
                        <th>Fecha resultado</th>
                        <th>Resultado</th>

                    </tr>
                    </thead>
                    <tbody>
                        @foreach($analisis as $registro)
                                @foreach($registro->resultados as $resultado)
                                    <tr>
                                        @if($loop->first)
                                        <td rowspan="{{$registro->resultados->count()}}">{{$registro->codigo}}</td>
                                        @endif
                                        <td>{{$resultado->tipoExamen ? $resultado->tipoExamen->nombre : '' }}</td>
                                        <td>{{$resultado->subTipoExamen ? $resultado->subTipoExamen->nombre : ''}}</td>
                                        <td>{{$resultado->fec_resultado ? $resultado->fec_resultado->format('d/m/Y') : ''}}</td>
                                        <td>{{$resultado->resultado}}</td>
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
