@if(!$promedios)
    <tr><td class="text-center" colspan="6">No se encontraron resultados :(</td></tr>
@else
    @foreach($promedios as $promedio)
        <tr>
            <td>{{$promedio->codigo}}</td>
            <td>{{$promedio->tipo_examen}}</td>
            <td>{{$promedio->sub_tipo_examen}}</td>
            <td>{{$promedio->fecha_registro}}</td>
            <td>{{$promedio->fecha_resultado}}</td>
            <td>{{$promedio->diferencia ?  $promedio->diferencia : '' }}</td>
        </tr>
    @endforeach
@endif
