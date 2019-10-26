<form id="form-store" action="#">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="col-lg-12">
            <label for="nombre">Nombre</label>
            <input maxlength="20" id="usuario" name="usuario" class="form-control required" value="">
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-lg-12">
            <label for="nombre">Contraseña</label>
            <input maxlength="20" id="contrasena" name="contrasena" class="form-control required" value="">
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-lg-12">
            <label for="nombre">Perfil</label>
            <select class="form-control required" name="perfil">
                <option value="">[Seleccione]</option>
                @foreach($perfiles as $perfil)
                    <option value="{{$perfil->id}}">{{$perfil->id}}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>
