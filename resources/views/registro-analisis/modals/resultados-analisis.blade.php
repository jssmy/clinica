<div class="tab-content" style="background: white; margin-top: 0px;">
    <table style="font-size: 11px;" class="table">
        <thead style="background-color: #3c8dbc; color: white;">
        <tr>
            <td>Tipo</td>
            <td>Sub-tipo</td>
            <td>Comentario</td>
            <td>Resultado</td>
        </tr>
        </thead>
        <tbody>
        @foreach($resultados as $resultado)
            <tr>
                <td>{{$resultado->tipoExamen ? $resultado->tipoExamen->nombre : ''}}</td>
                <td>{{$resultado->subTipoExamen ? $resultado->subTipoExamen->nombre : ''}}</td>
                <td>{{$resultado->comentario}}</td>
                <td>{{$resultado->resultado}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
