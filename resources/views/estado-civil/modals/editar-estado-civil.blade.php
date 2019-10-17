<form id="form-update" action="{{route('estado-civil.editar',$estado)}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="col-lg-12">
            <label for="nombre">Nombre</label>
            <input id="nombre" name="nombre" class="form-control required" value="{{$estado->nombre}}">
        </div>
    </div>
</form>
