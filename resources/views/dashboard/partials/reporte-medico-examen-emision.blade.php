<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
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
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{$analisis->unique('paciente_id')->count()}}</h3>
                <p>Total de pacientes atendidos</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-medkit-outline"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{round(($analisis->where('estado','PR')->count()/$analisis->count())*100,2)}}%</h3>
                <p>Exámenes preparados</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-pie-outline"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{round(($analisis->where('estado','AP')->count()/$analisis->count())*100,2)}}%</h3>
                <p>Exámenes aprobados</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-pie-outline"></i>
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
