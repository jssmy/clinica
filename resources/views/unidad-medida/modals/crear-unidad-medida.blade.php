<form id="form-tipo-seguro-store" action="{{route('unidad-medida.crear')}}">
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
            <textarea maxlength="300" id="descripcion" class="form-control required" name="descripcion" rows="4"></textarea>
        </div>
    </div>
</form>
