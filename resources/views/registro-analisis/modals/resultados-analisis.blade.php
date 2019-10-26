<div class="tab-content" style="background: white; margin-top: 0px;">
    <table style="font-size: 11px;" class="table">
        <thead style="background-color: #3c8dbc; color: white;">
        <tr>
            <td>Tipo</td>
            <td>Sub-tipo</td>
            <td>Comentario</td>
            <td>Resultado</td>
            <td>Opciones</td>
        </tr>
        </thead>
        <tbody>
        @foreach($resultados as $resultado)
                <tr>
                    <td>{{$resultado->tipoExamen ? $resultado->tipoExamen->nombre : ''}}</td>
                    <td>{{$resultado->subTipoExamen ? $resultado->subTipoExamen->nombre : ''}}</td>
                    <td>
                        @if($resultado->comentario)
                            {{$resultado->comentario}}
                        @else
                            <textarea  id="comentario{{$resultado->id}}" class="required" name="comentario" style="width: 400px;"></textarea>
                        @endif
                    </td>
                    <td>
                        @if($resultado->resultado)
                            {{$resultado->resultado}}
                        @else
                            <input id="resultado{{$resultado->id}}" style="width: 60px;" type="text" class="input-numeric form-control required" name="resultado">
                        @endif
                    </td>
                    <td>
                        @if(!$resultado->resultado && !$resultado->comentario)
                            <button
                                data-comentario="comentario{{$resultado->id}}"
                                data-resultado="resultado{{$resultado->id}}"
                                data-url="{{route('registro.analisis.guardar-resultado',$resultado)}}"
                                data-form="form-guardar-resultado{{$resultado->id}}"
                                class="btn  btn-xs btn-success btn-guardar-resultados"><i class="fa fa-save"></i> Guardar</button>
                        @endif
                    </td>
                </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script>
    $('.btn-guardar-resultados').on('click',function () {
        console.log()
        if($(this).is(':disabled')) return false;
        var url = $(this).data('url');
        var comentario=$("#"+$(this).data('comentario')).val();
        var resultado =$("#"+$(this).data('resultado')).val();
        //console.log(comentario,resultado);
        if(comentario=="" || resultado=="") return false;
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