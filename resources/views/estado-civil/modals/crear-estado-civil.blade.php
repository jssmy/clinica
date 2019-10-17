<form id="form-store" action="{{route('estado-civil.crear')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="col-lg-12">
            <label for="nombre">Nombre</label>
            <input maxlength="20" id="nombre" name="nombre" class="form-control required" value="">
        </div>
    </div>
</form>
