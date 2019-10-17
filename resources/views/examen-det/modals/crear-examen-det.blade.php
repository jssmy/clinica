<form id="form-store" action="{{route('examen-det.crear')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="col-sm-12">
            <label>Tipo de examen</label>
            <select name="tipo_examen" class="form-control required">
                <option value="">[Seleccione]</option>
                @foreach($tipo_examenes as $tipo)
                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-sm-12">
            <label>Insumo</label>
            <select name="insumo" class="form-control required">
                <option value="">[Seleccione]</option>
                @foreach($insumos as $insumo)
                    <option value="{{$insumo->id}}">{{$insumo->nombre}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-lg-12">
            <label for="nombre">Nombre</label>
            <input maxlength="100" id="nombre" name="nombre" class="form-control required" value="">
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-lg-12">
            <label for="descripcion">Descripción</label>
            <textarea maxlength="500" id="descripcion" class="form-control required" name="descripcion" rows="4"></textarea>
        </div>
    </div>
</form>
