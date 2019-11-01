@if(!$persona->usuario)
    <a href="{{route('usuario.crear',$persona)}}" id="btn-nuevo"><i class="fa fa-plus"></i> Crear usuario</a>
@else
    @if($persona->usuario->estado)
        <a data-url="{{route('usuario.resetear',$persona->usuario)}}"  href="#" id="btn-resetear"><i class="fa  fa-exclamation-triangle"></i> Resetear clave</a>
        <!--
        <a data-accion="inactivar" data-url="{{route('usuario.actualizar-estado',$persona->usuario)}}" style="padding-left: 15px;" href="#" class="btn-actualizar-estado"><i class="fa  fa-ban"></i> Inactivar</a>
        -->
    @else
        <!--
        <a data-accion="activar"  data-url="{{route('usuario.actualizar-estado',$persona->usuario)}}" style="padding-left: 15px;" href="#" class="btn-actualizar-estado"><i class="fa fa-check"></i> Activar</a>
        -->
    @endif
@endif
<script>
    $("#btn-resetear").click(function (e) {
        e.preventDefault();
        var url = $(this).data('url');
        var dialog = bootbox.dialog({
            title: "<b>¡Alerta!</b>",
            message: "<b>¿Estás seguro de resetear la contraseña?</b>",
            size: 'medium',
            buttons: {
                cancel: {
                    label: "CANCELAR",
                    className: 'btn btn-sm btn-default',
                    callback: function(){
                        return true;
                    }
                },
                ok: {
                    label: "CONFIRMAR",
                    className: 'btn btn-default btn-sm btn-info',
                    callback: function(){
                        var data = {_token : $("meta[name='csrf-token']").attr('content')}
                        $.ajax({
                            url : url,
                            type: 'put',
                            data: data,
                            success: function (view) {
                                $("#usuario-message").html(view);
                            }
                        });
                    }
                }
            }
        });
    });
</script>
