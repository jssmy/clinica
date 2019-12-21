<!DOCTYPE html>
<html lang="en">
<head>
    <title>Iniciar sesión</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{URL::asset('public/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{URL::asset('public/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{URL::asset('public/bower_components/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{URL::asset('public/dist/css/animate/animate.css')}}">

    <link rel="stylesheet" href="{{URL::asset('public/bower_components/css-hamburgers/hamburgers.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{URL::asset('public/bower_components/animsition/css/animsition.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/dist/css/util.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/dist/css/login.css')}}">

    <!--===============================================================================================-->
    <style>
        .error{
            border-color: #8a6d3b !important;
            border-width: 3px;
        }
    </style>
</head>
<body style="background-color: #666666;">

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <form class="login100-form validate-form" action="{{route('login.store')}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
					<span class="login100-form-title p-b-43">
                    BIENVENIDO AL SISTEMA WEB DE LABORATORIO CLÍNICO
					</span>
                <div class="wrap-input100 {{\Session::has('invalid') ? 'error' : '' }} validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                    <input class="input100" type="text" name="usuario">
                    <span class="focus-input100"></span>
                    <span class="label-input100">Usuario</span>
                </div>
                <div class="wrap-input100 {{\Session::has('invalid') ? 'error' : '' }} validate-input" data-validate="Password is required">
                    <input class="input100" type="password" name="contrasena" autocomplete="off">
                    <span class="focus-input100"></span>
                    <span class="label-input100">Contraseña</span>
                </div>
                <div class="container-login100-form-btn">
                    <button class="login100-form-btn">
                    ENTRAR
                    </button>
                </div>
                @if(\Session::has('invalid'))
                    <div id="error" style="color: #8a6d3b" class="alert">
                        <strong>¡Credenciales incorrectos!</strong> Por favor, intente de nuevo
                    </div>
                @endif

            </form>

            <div class="login100-more" style="background-image: url({{URL::asset('public/dist/img/background.jpg')}});">
                <img style="padding-top: 170px;padding-left: 30px" width="40%" src="{{URL::asset('public/dist/img/logo.png')}}">
            </div>
        </div>
    </div>
</div>




<script src="{{URL::asset('public/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{URL::asset('public/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('public/dist/js/login.js')}}"></script>
<script>
    $(".login100-form-title").trigger('click');
    $(".input100").keydown(function () {
        $(".error").removeClass('error');
        $("#error").remove();
    });
</script>
</body>
</html>
