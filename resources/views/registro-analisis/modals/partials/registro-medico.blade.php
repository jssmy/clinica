<div class="col-sm-12">
    <br>
    <label><i class="fa  fa-user-md"></i> Datos del Médico</label>
    <hr style="margin-top: 0px;">

        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="medico_id" value="{{$persona->id}}">
        <div>
            <span style="font-size: 25px; color: #337ab7"> {{$persona->nombre_completo}}  </span>
            <br>
            <div class="invoice-col" style="padding:10px; ">
                <div style="padding-top: 5px">
                    <span style="color: #606060; font-weight: bold;">Nro. Documento:</span>
                    <span style="color: rgba(33, 32, 36, 0.52)">{{$persona->numero_documento}}</span>
                </div>
                <div style="padding-top: 5px">
                    <span style="color: #606060; font-weight: bold;">Nro. Colegiatura
                    </span>
                    <span style="color: rgba(33, 32, 36, 0.52)">{{optional($persona->empleado)->numero_colegiatura}}</span>
                </div>
            </div>
        </div>


</div>
