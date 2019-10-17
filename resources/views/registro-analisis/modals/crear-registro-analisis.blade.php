<div class="row text-center">
    <label class="col-sm-5" for="nombre">DNI del paciente</label>
    <div class="col-sm-7">
        <div class="input-group">
            <input  id="dni-paciente" data-span="btn-search-paciente" name="numero_documento" class="form-control numero_documento input-digits">
            <span
                  id="btn-search-paciente"
                  data-tipo="paciente"
                  data-incorrecto='<i class="fa  fa-ban"></i> Incorrecto'
                  data-search='<i class="fa  fa-search"></i>'
                  data-url="{{route('registro.encontrar-presona',['tipo','numero_documento'])}}"
                  data-not-found="<i class='fa fa-remove'></i> No encontrado"
                  data-found="<i class='fa fa-check'></i> Encontrado"
                  data-searching="<i class='fa fa-circle-o-notch fa-spin'></i> Buscando"
                  data-input="dni-paciente"
                  style="background-color: rgb(102,205,0); color: white;" class="btn input-group-addon btn-search">
                <i class="fa  fa-search"></i>
            </span>
        </div>
    </div>
</div>
<div id="registro-persona-resultado" class="row">
</div>
<div class="row text-center" style="margin-top: 15px;">
    <label class="col-sm-5" for="nombre">DNI Médico/ Nro. Colegiatura</label>
    <div class="col-sm-7">
        <div class="input-group">
            <input  id="dni-medico" data-span="btn-search-medico" name="numero_documento" type="text" class="form-control numero_documento input-numeric" >
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
                style="background-color: rgb(102,205,0); color: white;" class="btn input-group-addon btn-search">
                <i class="fa  fa-search"></i>
            </span>
        </div>
    </div>
</div>
<div id="registro-medico-resultado" class="row">
</div>
<hr>
<div class="row">
    <div class="col-sm-6">
        <label>Tipo de examen</label>
        <select name="examen_cab_id" class="form-control required">
            <option>[Seleccione]</option>
            @foreach($tiposExamen as $tipo)
                <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-6">
        <label>Sub-tipo de examen</label>
        <select name="examen_det_id" class="form-control required">
            <option>[Seleccione]</option>

        </select>
    </div>
</div>

<script>

    $(".btn-search").click(function () {
        var numero_documento = $("#"+$(this).data('input')).val();
        var url =  $(this).data('url').replace('numero_documento',numero_documento).replace('tipo',$(this).data('tipo'));
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
            }, error: function (err) {
                if(err.status==422){
                    console.log("error");
                    btn.html(btn.data('search'));
                    if(btn.data('tipo')=='medico'){
                        $("#registro-medico-resultado").html('<div class="col-sm-12 text-center">No encontrado</div>');
                    }else {
                        $("#registro-persona-resultado").html('<div class="col-sm-12 text-center">No encontrado</div>');
                    }
                }
            }
        });
    });

    $("select[name=examen_cab_id]").on('change',function () {
        var examen_det = $(this).val();

    });

</script>
