<form id="form-store" action="{{route('perfil.crear')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="col-lg-12">
            <label for="codigo">Perfil</label>
            <input maxlength="3" id="codigo" name="perfil" class="form-control required" value="">
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-lg-12">
            <label for="descripcion">Descripción</label>
            <textarea maxlength="50" id="descripcion" class="form-control required" name="descripcion" rows="3"></textarea>
        </div>
    </div>
</form>
