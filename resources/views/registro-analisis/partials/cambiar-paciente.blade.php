<form id="form-cambiar-paciente" action="{{route('registro.analisis.cambiar.store',$analisis)}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div id="error" class="col-sm-12"></div>
    </div>
    <div class="row">
        <div style="min-width: 300px; width: 50%" class="col-sm-12 invoice-col pull-right">
            <div class="input-group input-group-sm">
                <input maxlength="8" data-btn="btn-search-paciente" placeholder="Buscar paciente por DNI" id="dni-medico" data-span="btn-search-medico" name="numero_documento" type="text" class="form-control numero_documento input-submit input-digits">
                <div class="input-group-btn">
                            <span
                                id="btn-search-paciente"
                                data-tipo="paciente"
                                data-incorrecto='<i class="fa  fa-ban"></i> Incorrecto'
                                data-search='<i class="fa  fa-search"></i>'
                                data-url="{{route('registro.encontrar-presona',['tipo','numero_documento'])}}"
                                data-not-found="<i class='fa fa-remove'></i> No encontrado"
                                data-found="<i class='fa fa-check'></i> Encontrado"
                                data-searching="<i class='fa fa-circle-o-notch fa-spin'></i> Buscando"
                                data-input="dni-medico"
                                style="background-color: #31708f; color: white;" class="btn input-group-addon btn-search">
                    <i class="fa  fa-search"></i>
                </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-sm-12">
            <label>Datos del análisis</label>
            <div class="tab-content" style="background: white; margin-top: 0px;">
                <div style="display: flex;">
                    <div id="home" class="fade in active content-section" style="display: flex; flex-direction: column; justify-content: space-between; flex:2; margin-right: 3px; background: #f8f8f8; border-radius: 11px;">
                        <div style="display: flex; height: 100%">
                            <div class="invoice-col" style=" border-right: 1px solid #dad9d9f7; display: flex; min-width: 200px;  justify-content: center; align-items: center">
                                <div style="display: flex; flex-direction: column;">
                                    <div style="display: flex; flex-direction: row;">
                                        <div class="text-center" style="padding: 10px">
                                            <div class="text-center" style="padding: 5px">
                                            <span class="success">
                                        <b><i class="fa fa-5x fa-heartbeat"></i></b>
                                        <br>
                                        <b>ANÁLISIS</b>
                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; flex: 1; flex-direction: column;  justify-content: space-around;">
                                <div style="display: flex">
                                    <div class="invoice-col" style="padding:10px; ">
                                        <div style="padding-top: 5px">
                                            <label style="color: #606060; font-weight: bold;">Código de analisis:</label>
                                            <label style="color: rgba(33, 32, 36, 0.52)">{{$analisis->codigo}}</label>
                                        </div>
                                        <div style="padding-top: 5px">
                                            <span style="color: #606060; font-weight: bold;">Médico clínica:</span>
                                            <span style="color: rgba(33, 32, 36, 0.52)">{{$analisis->medico ? $analisis->medico->nombre_completo : ''}}</span>
                                        </div>
                                        <div style="padding-top: 5px">
                                            <span style="color: #606060; font-weight: bold;">Fecha de registro:</span>
                                            <span style="color: rgba(33, 32, 36, 0.52)">{{$analisis->fec_registro->format('d/m/y')}}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-sm-12">
            <label>Datos del paciente</label>
            <hr style="margin-top: 0px;">
            <div id="registro-paciente-resultado">
                <div class="text-center">
                    Sin vista previa
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(".btn-search").click(function () {
        if($(this).is('is:disabled')) return false;
        var numero_documento = $("#"+$(this).data('input')).val();
        var url =  $(this).data('url').replace('numero_documento',numero_documento).replace('tipo',$(this).data('tipo')) + '?section=registro_analisis';
        console.log(url);
        var btn = $(this);

        $.ajax({
            url: url,
            type: 'get',
            success: function (view) {
                $("#registro-paciente-resultado").html(view);
                btn.html(btn.data('search'));

            },beforeSend: function () {
                btn.html(btn.data('searching'));
                btn.attr('disabled',true);
            }, error: function (err) {
                if(err.status==422){
                    console.log("error");
                    btn.html(btn.data('search'));
                        $("#registro-paciente-resultado").html('<div class="col-sm-12 text-center" style="color: red">No encontrado</div>');
                }
            }, complete: function () {
                btn.removeAttr('disabled');
            }
        });
    });
</script>
