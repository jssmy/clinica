<style>
    .fixed_header{

        table-layout: fixed;
        border-collapse: collapse;
    }

    .fixed_header tbody{
        display:block;
        width: 100%;
        overflow: auto;
        max-height: 400px;
    }

    .fixed_header thead tr {
        display: block;
    }

    .fixed_header th, .fixed_header td {
        padding: 5px;
        text-align: left;

    }
</style>
<div class="row">
    <div id="error" class="col-sm-12">
    </div>
</div>
<div class="tab-content " style="background: white; margin-top: 0px;">
    <form id="form-resultados" action="{{route('registro.analisis.guardar-resultado',$analisis)}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <table style="font-size: 11px;" class="table fixed_header">
            <thead style="background-color: #3c8dbc; color: white;">
            <tr>
                <td style="width: 180px;">Tipo</td>
                <td style="width: 100px">Sub-tipo</td>
                <td style="width: 70px">Fecha resultado</td>
                <td style="width: 420px">Comentario</td>
                <td>Resultado</td>
            </tr>
            </thead>
            <tbody>
            @foreach($analisis->resultados as $resultado)
                <tr>
                    <td style="width: 180px;">{{$resultado->tipoExamen ? $resultado->tipoExamen->nombre : ''}}</td>
                    <td style="width: 100px">{{$resultado->subTipoExamen ? $resultado->subTipoExamen->nombre : ''}}</td>
                    <td style="width: 60px">{{$resultado->fec_resultado ? $resultado->fec_resultado->format('d/m/Y') : '' }}</td>
                    @if(auth()->user()->es_tecnologo)
                        <td style="width: 400px">
                            <textarea maxlength="200"  rows="3" id="comentario{{$resultado->id}}" class="form-control" name="resultado[{{$resultado->id}}][comentario]" style="width: 400px;">{{$resultado->comentario}}</textarea>
                        </td>
                        <td>
                            <input {{$resultado->resultado ? 'readonly' : ''}} value="{{$resultado->resultado}}" style="width: 60px;height: 51px;" type="text" class="input-numeric form-control required" name="resultado[{{$resultado->id}}][valor]">
                        </td>
                    @else

                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>
</div>
<script>
    $('.btn-guardar-resultados').on('click',function () {
        console.log()
        if($(this).is(':disabled')) return false;
        var url = $(this).data('url');
        var comentario=$("#"+$(this).data('comentario')).val();
        var resultado =$("#"+$(this).data('resultado')).val();
        //console.log(comentario,resultado);
        if(resultado=="") return false;
        var data={
            comentario :  comentario,
            resultado :   resultado,
            _token :  $("meta[name='csrf-token']").attr('content')
        };
        var btn = $(this);
        $.ajax({
            url: url,
            type : 'put',
            data: data,
            success: function (message) {
                toastr["success"](message.message);
                $("#"+btn.data('comentario')).attr('disabled',true);
                $("#"+btn.data('resultado')).attr('disabled',true);
                btn.remove();
                load_table();
            }, beforeSend: function () {
                btn.attr('disabled',true);
            },complete: function () {

            }
        });
    });
</script>
