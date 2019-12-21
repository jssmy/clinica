<style>
    #targetOuter{
        position:relative;
        text-align: center;
        background-color: #F0E8E0;
        width: 200px;
        height: 200px;
        border-radius: 4px;
    }
    .btnSubmit {
        background-color: #565656;
        border-radius: 4px;
        padding: 10px;
        border: #333 1px solid;
        color: #FFFFFF;
        width: 200px;
        cursor:pointer;
    }
    .inputFile {
        padding: 5px 0px;
        margin-top:8px;
        background-color: #FFFFFF;
        width: 48px;
        overflow: hidden;
        opacity: 0;
        cursor:pointer;
    }
    .icon-choose-image {
        position: absolute;
        opacity: 0.1;
        top: 50%;
        left: 50%;
        margin-top: -24px;
        margin-left: -24px;
        width: 48px;
        height: 48px;
    }
    .upload-preview {border-radius:4px;width:200px;height:200px;}
    #body-overlay {background-color: rgba(0, 0, 0, 0.6);z-index: 999;position: absolute;left: 0;top: 0;width: 100%;height: 100%;display: none;}
    #body-overlay div {position:absolute;left:50%;top:50%;margin-top:0px;margin-left:-32px;}
</style>
<div class="row">
    <form id="form-store" action="#">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="col-sm-6">
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
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div  id="demo-content" class="col-sm-12 text-center">
                    <label>Foto del usuario</label>
                    <div id="body-overlay">
                        <div>
                            <img src="{{URL::asset('public/dist/img/loading.gif')}}" width="64px" height="64px">
                        </div>
                    </div>
                    <div class="bgColor">
                        <div id="targetOuter">
                            <div id="targetLayer"></div>
                            <img src="{{URL::asset('public/dist/img/load-photo.png')}}" class="icon-choose-image">
                            <div class="icon-choose-image">
                                <input name="userImage" accept="image/*"  id="userImage" type="file" class="inputFile" onchange="showPreview(this);">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    function showPreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#targetLayer").html('<img src="'+e.target.result+'" class="upload-preview" />');
                $("#targetLayer").css('opacity','0.7');
                $(".icon-choose-image").css('opacity','0.5');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
