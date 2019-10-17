<form id="form-store" action="{{route('insumo.crear')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="col-lg-12">
            <label for="nombre">Nombre</label>
            <input maxlength="100" id="nombre" name="nombre" class="form-control required" value="">
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-lg-12">
            <label for="descripcion">Descripción</label>
            <textarea maxlength="500" id="descripcion" class="form-control required" name="descripcion" rows="3"></textarea>
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-lg-12">
            <label for="uso">Uso</label>
            <textarea maxlength="500" id="uso" class="form-control required" name="uso" rows="3"></textarea>
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-lg-6">
            <label for="unidad_medida_id">Unidad de medida</label>
            <select name="unidad_medida_id" class="form-control required">
                <option value="">[Seleccione]</option>
                @foreach($unidades as $unidad)
                    <option value="{{$unidad->id}}">{{$unidad->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-6">
            <label for="cantidad">Cantidad</label>
            <input class="form-control required" name="cantidad">
        </div>
    </div>

</form>
<br>
<br>
