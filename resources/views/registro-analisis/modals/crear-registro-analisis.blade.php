<form id="form-store" action="{{route('registro-analisis.crear')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}" >
    <div class="row">
        <div id="error" class="col-sm-12">

        </div>
    </div>
    @if($persona->es_paciente)
        <input type="hidden" name="paciente_id"  value="{{$persona->id}}">
        <div class="row col-sm-12">
            <div style="min-width: 300px; width: 50%" class="invoice-col pull-right">
                <div class="input-group input-group-sm">
                    <!-- /btn-group -->
                    <input data-btn="btn-search-medico" placeholder="Buscar médico por DNI" id="dni-medico" data-span="btn-search-medico" name="numero_documento" type="text" class="form-control numero_documento input-submit input-digits">
                    <div class="input-group-btn">
                            <span
                                id="btn-search-medico"
                                data-tipo="medico"
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
    @endif
    <div class="row">
        <div class="col-sm-12">
            <label>Datos del médico</label>
            <hr style="margin-top: 0px;">
            <div id="registro-medico-resultado">
                <div class="text-center">
                    Sin vista previa
                </div>
            </div>
        </div>
    </div>
    <br>
    <div>
        <label>Resultado de exámenes clínicos</label>
        <hr style="margin-top: 0px;">
    </div>
    <div class="row">
        <div class="col-sm-3">
            <label>Tipo de examen</label>
            <select name="examen_cab_id" class="form-control required" data-url="{{route('examen-cab.submotivo','motivo_id')}}">
                <option value="">[Seleccione]</option>
                @foreach($tiposExamen as $tipo)
                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-4">
            <label>Sub-tipo de examen</label>
                <select name="examen_det_id" class="form-control required">
                <option value="">[Seleccione]</option>
            </select>
        </div>
        <div class="col-sm-1">
            <br>
            <button id="btn-agregar-motivos" type="button" style="margin-top: 4px;" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Agregar</button>
        </div>
    </div>
    <div style="margin-top: 20px" class="row">
        <div class="col-sm-9">
            <label>Exámenes agregados</label>
            <table class="table table-striped table-responsive" >
                <tbody id="tbl-motivos" ></tbody>
            </table>
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
                if(btn.data('tipo')=='medico'){
                    $("#registro-medico-resultado").html(view);
                }else {
                    $("#registro-persona-resultado").html(view);
                }

                btn.html(btn.data('search'));
            },beforeSend: function () {
                btn.html(btn.data('searching'));
                btn.attr('disabled',true);
                $("#error").html("")
            }, error: function (err) {
                if(err.status==422){
                    console.log("error");
                    btn.html(btn.data('search'));
                    if(btn.data('tipo')=='medico'){
                        $("#registro-medico-resultado").html('<div class="col-sm-12 text-center" style="color: red">No encontrado</div>');
                    }else {
                        $("#registro-persona-resultado").html('<div class="col-sm-12 text-center" style="color: red">No encontrado</div>');
                    }
                }
            }, complete: function () {
                btn.removeAttr('disabled');
            }
        });
    });

    $("select[name=examen_cab_id]").on('change',function () {
        var examen_det = $(this).val();
        var url = $(this).data('url').replace('motivo_id',examen_det);
        var options="<option value=''>[Seleccione]</option>";
        $.get(url, function (submotivos) {
            submotivos.forEach(function (submotivo) {
                options+="<option value='"+submotivo.id+"'>"+submotivo.nombre+"</option>";
            });
            $("select[name=examen_det_id]").html(options);
        });
    });
    var motivosArr=[];
    $(document).on('click','#btn-agregar-motivos',function () {
        var examen_cab = $("select[name=examen_cab_id]").val();
        var examen_det = $("select[name=examen_det_id]").val();
        var examen_cab_text = $("select[name=examen_cab_id]").find('option:selected').text();
        var examen_det_text =$("select[name=examen_det_id]").find('option:selected').text();
        $("#error").html("");
        console.log(examen_det,examen_det_text,examen_cab,examen_cab_text);
        if(examen_det!="" && examen_cab!="" && $.inArray(examen_det,motivosArr)==-1){
            motivosArr.push(examen_det);
            console.log(motivosArr);
            var eliminar ="<td style='display: flex !important;text-align: center !important;justify-content: space-around !important;'><a id='"+examen_det+"' href='#' class='eliminar_tipo_examen'> <i class='fa fa-remove'></i></a></td>";
            var input="<input type='hidden' name='tipos_examen["+examen_cab+"][]' value='"+examen_det+"'>";
            var tr="<tr><td>"+input+examen_cab_text+"</td><td>"+examen_det_text+"</td><td>"+eliminar+"</tr>";
            $("#tbl-motivos").append(tr);
        }
    })
    $(document).on('click','.eliminar_tipo_examen',function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        var i = $(this).attr('id');

        var index = motivosArr.indexOf(i);
        console.log(motivosArr);
        console.log(i,index);
        //console.log(i,index);
        motivosArr.splice(index,1);
    });
</script>
