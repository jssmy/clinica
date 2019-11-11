@forelse($produccion as $prod)
    <tr>
        <td>{{{$prod->MES}}}</td>
        <td>{{{$prod->TipoExamen}}}</td>
        <td>{{{$prod->SubTipoExamen}}}</td>
        <td>{{{$prod->PAGANTES}}}</td>
        <td>{{{$prod->SIS}}}</td>
    </tr>
@empty
    <tr><td colspan="7" class="text-center">No hay registros para mostrar</td></tr>
@endforelse
