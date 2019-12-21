<table class="table table-hover table-striped" style="font-size:12px;">
    <thead style="background-color: #3c8dbc; color: white">
    <tr>
        <th style="width: 120px;">DÍA</th>
        <th>Fecha</th>
        <th style="width: 30px;">NP</th>
        <th style="width: 100px;">TP (minutos)</th>
    </tr>
    </thead>
    <tbody data-empty='<tr><td colspan="4" class="text-center">No hay registros para mostrar</td></tr>' id="registros-body">
        @forelse($resultados as $resultado)
            <tr>
                <td>{{$loop->index+1}}</td>
                <td>{{$resultado->fecha_registro}}</td>
                <td>{{$resultado->cantidad_resultado}}</td>
                <td>{{$resultado->TP}}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center">No hay registros para mostrar</td></tr>
        @endforelse
    </tbody>
</table>