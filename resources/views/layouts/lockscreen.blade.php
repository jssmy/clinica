<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Actualizar contraseña | Clínica</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{URL::asset('public/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{URL::asset('public/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{URL::asset('public/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{URL::asset('public/dist/css/AdminLTE.min.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
        <a href="#"><b>Santa</b>Rosa</a>
    </div>
    <!-- User name -->
    <div class="lockscreen-name">{{$usuario->usuario}}</div>

    <!-- START LOCK SCREEN ITEM -->
    <div class="lockscreen-item" style="margin-bottom: 0px !important;">
        <!-- lockscreen image -->
        <div class="lockscreen-image" style="left: -35px !important; top: -6px !important;">
            <img src="{{URL::asset($usuario->imagen_url)}}" alt="User Image">
        </div>
        <!-- /.lockscreen-image -->
        <!-- lockscreen credentials (contains the form) -->
        <form id="form-contrasena" class="lockscreen-credentials">
            <input type="hidden" name="_token" value="{{csrf_token()}}">

            <div class="input-group">
                <input type="password" class="form-control required" name="contrasena" placeholder="Nueva contraseña" autocomplete="off">
                <input type="password" class="form-control required" name="confirmar_contrasena" placeholder="Confirmar contraseña" autocomplete="off">
                <div class="input-group-btn">
                    <button id="btn-cambiar-contrasena" type="button" class="btn hide"><i class="fa fa-arrow-right text-muted"></i></button>
                </div>
            </div>
        </form>
        <!-- /.lockscreen credentials -->
    </div>
    <div id="contrasena-error" class="text-center" style="color: #9b5511"></div>
    <!-- /.lockscreen-item -->
    <div class="help-block text-center" style="padding-top: 50px;">
        Por favor cambie su contraseña
    </div>

    <div id="success" class="lockscreen-footer text-center">

    </div>
</div>
<!-- /.center -->

<!-- jQuery 3 -->
<script src="{{URL::asset('public/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{URL::asset('public/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<script src="{{URL::asset('public/plugins/toastr/toastr.min.js')}}"></script>

<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "maxOpened": 4
    }
    $("input[name=contrasena]").keyup(function (e) {
        $("#contrasena-error").html("");

        var contrasena = $("input[name=confirmar_contrasena]").val();

        if($(this).val().length<=7){
            $("#contrasena-error").html("La contraseña debe tener más de 7 dígitos");
            $("#btn-cambiar-contrasena").addClass('hide');
            return ;
        }

        if($(this).val()==contrasena && contrasena && $(this).val()){
            $("#btn-cambiar-contrasena").removeClass('hide');
        }else {
            $("#contrasena-error").html("Las contraseñas no coindiden");
            $("#btn-cambiar-contrasena").addClass('hide');
        }
    });

    $("input[name=confirmar_contrasena]").keyup(function (e) {
        $("#contrasena-error").html("");
        var contrasena = $("input[name=contrasena]").val();

        if($(this).val().length<=7) {
            $("#contrasena-error").html("La contraseña debe tener más de 7 dígitos");
            $("#btn-cambiar-contrasena").addClass('hide');
            return;
        }

        if($(this).val()==contrasena && contrasena && $(this).val()){
            $("#btn-cambiar-contrasena").removeClass('hide');
        }else {
            $("#contrasena-error").html("Las contraseñas no coindiden");
            $("#btn-cambiar-contrasena").addClass('hide');
        }
    });
    var url_nueva_contrasena = "{{route('login.nueva-contrasena',$usuario)}}";
    var url_login ="{{route('login-form')}}";
    $("#btn-cambiar-contrasena").click(function () {
        var form = $("#form-contrasena");
        $.ajax({
            url: url_nueva_contrasena,
            type: 'post',
            data: form.serializeArray(),
            success: function (message) {
                $("#success").html('<label class="label label-success">Se ha cambiado la contraseña, por favor inicie sessión con su nueva contraseña <i class="fa fa-check"></i></label>');
                setTimeout(function () {
                    window.location.href = url_login; //will redirect to your blog page (an ex: blog.html)
                },2000*1.5);
            }
        });
    });
</script>
</body>
</html>
