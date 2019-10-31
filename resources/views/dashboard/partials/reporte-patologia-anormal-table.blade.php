@if(!$patologias)
    <tr><td class="text-center" colspan="6">No se encontraron resultados :(</td></tr>
@else
    @foreach($patologias as $patologia)
        <tr>
            <td>{{$patologia->codigo}}</td>
            <td>{{$patologia->paciente}}</td>
            <td>{{$patologia->tipo_examen}}</td>
            <td>{{$patologia->sub_tipo_examen}}</td>
            <td>{{$patologia->resultado}}</td>
            <td>{{$patologia->observacion}}</td>
        </tr>
    @endforeach

@endif
