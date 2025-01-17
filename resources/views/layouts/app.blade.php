<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')-Clínica</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{URL::asset('public/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{URL::asset('public/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->

  <!-- Theme style -->
  <link rel="stylesheet" href="{{URL::asset('public/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{URL::asset('public/dist/css/skins/_all-skins.min.css')}}">
  <!-- Morris chart -->
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{URL::asset('public/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{URL::asset('public/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{URL::asset('public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  <link rel="stylesheet" href="{{URL::asset('public/plugins/toastr/toastr.min.css')}}">
        @yield('styles')

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style>
        ul.pagination li a,ul.pagination li span{
            border-radius: 50% !important;
        }
        label.error{
            color: #d63b3b;
        }
        .content-wrapper {
            min-height: 100%;
            background-color: #fff;
            z-index: 800;
        }

        .tab-pane table, .tab-pane table thead tr{
            background: #fff;
        }

        #search-section {
            padding: 30px;
        }

        .box {
            background: #f6f6f6;
            border-top: 1px solid white;
        }

        .title-section {
            color: #665a5a;
            font-weight: bold;
        }

        .content-title {
            align-items: center;
            display: flex;
            flex: 1;
        }

        .content-close {
            display: flex;
            align-items: center;
            color: #969191;
        }

        .content-section {
            background: #f8f8f8;
        }

        .box-header {
            background: #fff !important;
            cursor:pointer;
            display: flex;
        }
        .box-title {
            color: #665a5a;
            font-weight: bold;
            font-size: 14px !important;
        }

        .collapse-icon {
            margin-left: 6px;
            color: #969191; cursor: pointer;
            font-size: 27px;
        }

        .mt-text-red {
            color: #f60e63;
        }

        .mt-text-green {
            color: #5cc500;
        }

        .mt-text-orange {
            color: #ff9851;
        }

        .mt-bg-red {
            background: #e9426d; /*#f60e63;*/
        }

        .mt-bg-green {
            background: #5cc500;
        }

        .mt-bg-orange {
            background: #ff9851;
        }

        .mt-bg-gray {
            background: #eaeaea;
        }

        .mt-info {
            background: #00dede;
            color: #fff;
            border-radius: 4px;
        }

        .control-label{
            color: #4e4e4e;
        }

        .select2.select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border-radius: 0px;
            border: 1px solid #d2d6de;
            height: 34px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3c8dbc;
            color: #fff;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
        }

        label.error {
            color: #ff5b46;
        }

        input[type=text].error {
            box-shadow: 0px 0px 2px 0px;
            border-color: #ff5b46;
        }

        input[type=email].error {
            box-shadow: 0px 0px 2px 0px;
            border-color: #ff5b46;
        }

        select.error {
            box-shadow: 0px 0px 2px 0px;
            border-color: #ff5b46;
        }

        textarea.error {
            box-shadow: 0px 0px 2px 0px;
            border-color: #ff5b46;
        }
        .btn{
            border-radius: 15px;
        }

    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<input type="hidden" id="_token" value="{{csrf_token()}}">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{route('clinica.index')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Snt</b>R</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Santa Rosa</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{URL::asset(auth()->user()->imagen_url)}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{auth()->user()->persona->nombre}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{URL::asset(auth()->user()->imagen_url)}}" class="img-circle" alt="User Image">

                <p>
                  {{auth()->user()->usuario}}
                  <small>Se unió el {{auth()->user()->fecha_registro}}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">

                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                    <form action="{{route('logout.store')}}" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button  type="submit" class="btn btn-default btn-flat">Cerrar sesión</button>
                    </form>

                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel" style="margin-bottom: 30px;">
        <div class="pull-left image">
          <img src="{{URL::asset(auth()->user()->imagen_url)}}" style="width: 50px !important;height: 50px !important;" class="img-circle" alt="User Image">
        </div>
        <div  class="pull-left info">
          <p style="font-size: 16px;">{{auth()->user()->usuario}}</p>
            <label style="font-size: 11px;">{{auth()->user()->perfil->descripcion}}</label>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      @include('layouts.partials.menu')
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
        <div class="notify-message"></div>
      @yield('content')
    </section>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->

<script src="{{URL::asset('public/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{URL::asset('public/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{URL::asset('public/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<script src="{{URL::asset('public/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{URL::asset('public/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{URL::asset('public/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>

<!-- datepicker -->
<!--
<script src="{{URL::asset('pulic/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
-->

<script src="{{URL::asset('public/dist/js/adminlte.min.js')}}"></script>
<script src="{{URL::asset('public/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{URL::asset('public/bower_components/jquery-validation/jquery.validate.min.js')}}"></script>



@yield('scripts')
<script>


    function msg_404(msg){

        if (msg == undefined) {
            msg = 'No se encontraron resultados';
        }

        return "<div class=\"alert alert-info alert-dismissible\" style='margin-top: 20px; margin-bottom: 10px;'>" +
            "<i class=\"icon fa fa-info\"></i> <span>"+msg+"</span>" +
            "</div>"
    }

    function msg_200(msg){

        return "<div class=\"alert alert-success alert-dismissible\" style='margin-top: 20px; margin-bottom: 10px;'>" +
            "<i class=\"icon fa fa-info\"></i> <span>"+msg+"</span>" +
            "</div>"
    }

    function msg_500(msg){

        if (msg == undefined) {
            msg = 'Error de servidor.';
        }

        return "<div class=\"alert alert-danger alert-dismissible\" style='margin-top: 20px; margin-bottom: 10px;'>\n" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>\n" +
            "<h4><i class=\"icon fa fa-warning\"></i> ¡Error!</h4>\n" +
            msg +
            "</div>"
    }

    function msg_422(msg){

        var msgs = '';
        $.each(msg, function(k, v){
            msgs += "<li>" + v + "</li>";
        });

        var alert = "<div class=\"alert alert-danger alert-dismissible\" style='margin-top: 20px; margin-bottom: 10px;'>\n" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>\n" +
            "<h4><i class=\"icon fa fa-warning\"></i> ¡Error!</h4>\n" +
            msgs +
            "</div>"

        return alert;
    }

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

    var serialiseObject = function(obj) {
        var pairs = [];
        for (var prop in obj) {
            if (!obj.hasOwnProperty(prop)) {
                continue;
            }
            if (Object.prototype.toString.call(obj[prop]) == '[object Object]') {
                pairs.push(serialiseObject(obj[prop]));
                continue;
            }
            pairs.push(prop + '=' + obj[prop]);
        }
        return pairs.join('&');
    };

    function msg_alert_422(msg){

        var msgs = '';
        $.each(msg, function(k, v){
            msgs += "<li>" + v + "</li>";
        });

        var alert = "<div class=\"alert alert-warning alert-dismissible\" style='margin-top: 20px; margin-bottom: 10px;'>\n" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>\n" +
            "<h4><i class=\"icon fa fa-warning\"></i> Alerta!</h4>\n" +
            msgs +
            "</div>"

        return alert;
    }

    function format_numeric(value) {
        return /^\d*[.]?\d{0,2}$/.test(value);
    }

    function format_digits(value) {
        return /^\d*?$/.test(value);
    }

    function format_text(value) {
        return /^[áéíóúñÁÉÍÓÚÑa-zA-Z ]*\s*$/.test(value);
    }

    function format_digits_sometext(value) {
        return /^[cCxXkK0-9]*\s*$/.test(value);
    }

    function format_text_digits(value) {
        return /^[a-zA-Z0-9-_]*\s*$/.test(value);
    }
    function format_date(value) {
        return /^([1-9]{4})+-+([0-9]{2})+([0-9]{2})$/.test(value);
    }


    var datePickerRangeOption = {
        "format": "DD-MMMM-YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "a",
        "customRangeLabel": "Personalizar",
    };

    jQuery.extend(jQuery.validator.messages, {
        required: "Este campo es obligatorio.",
        remote: "Por favor, rellena este campo.",
        email: "Por favor, escribe una dirección de correo válida",
        url: "Por favor, escribe una URL válida.",
        date: "Por favor, escribe una fecha válida.",
        dateISO: "Por favor, escribe una fecha válida.",
        number: "Por favor, escribe un número entero válido.",
        digits: "Por favor, escribe sólo dígitos.",
        creditcard: "Por favor, escribe un número de tarjeta válido.",
        equalTo: "Por favor, escribe el mismo valor de nuevo.",
        accept: "Por favor, escribe un valor con una extensión aceptada.",
        maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
        minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
        rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
        range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
        max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
        min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
    });
    $(document).ready(function () {

    $(".daterangepicker_input input").attr('readonly',true);

        $(document).on("keypress", "form", function (event) {
            return event.keyCode != 13;
        });

        /* Show error request
           ------------------ */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
            },
            success: function(message){
                if(message==undefined) return  true;
                if(message.message){
                    toastr["success"](message.message);
                    return true;
                }
            },
            error: function (err) {
                if (err.status == 401) {
                    bootbox.dialog({
                        title: 'Alerta',
                        message: "<h4>¡" + err.responseJSON + "!</h4>",
                        buttons: {
                            ok: {
                                label: "ACEPTAR",
                                className: 'btn-info',
                                callback: function () {

                                }
                            }
                        }
                    });
                }

                if (err.status == 403) {
                    bootbox.dialog({
                        title: 'Alerta',
                        message: "<h4>¡" + err.responseJSON + "!</h4>",
                        buttons: {
                            ok: {
                                label: "ACEPTAR",
                                className: 'btn-info',
                            }
                        }
                    });
                }

                if (err.status == 422) {
                    console.log(err.responseJSON.errors);
                    if (err.responseJSON.errors.numero_empresas != undefined) {
                        $(".notify-message:last").html(msg_alert_422(err.responseJSON.errors));
                    } else {
                        $(".notify-message:last").html(msg_alert_422(err.responseJSON.errors));
                    }

                    $("html, body").animate({
                        scrollTop:$(".notify-message:last").scrollTop()
                    }, 600);
                }

                if (err.status == 404) {
                    $(".notify-message:last").html(msg_404(err.responseJSON));
                }

                if (err.status == 500) {
                    toastr["error"]('Hubo un problema al realizar esta acción. Por favor vuelva a intentarlo.');
                }
            }
        });


        /* Format input allow
           ------------------ */

        (function ($) {
            $.fn.inputFilter = function (inputFilter) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    }
                });
            };
        }(jQuery));

        $(document).on('keypress','.input-submit', function (e) {
            if (e.which === 13) { //enter
                $("#"+$(this).data('btn')).trigger('click');
            }
        });

        /*Numeros con decimal*/
        $(".input-numeric").inputFilter(function (value) {
            return format_numeric(value);
        });
        /*Numeros sin decimal*/
        $(".input-digits").inputFilter(function (value) {
            return format_digits(value);
        });
        /*Solo letras*/
        $(".input-text").inputFilter(function (value) {
            return format_text(value);
        });

        /*Solo letras y numeros para código de reclamo*/
        $(".input-text-digits").inputFilter(function (value) {
            return format_text_digits(value);
        });

        /*Solo numeros y algunas letras para nro de servicio y cuentas*/
        $(".input-digits-sometext").inputFilter(function (value) {
            return format_digits_sometext(value);
        });

        /* Jquery Validation extends methods
           --------------------------------- */
        jQuery.validator.setDefaults({
            debug: true
        });

        jQuery.validator.addMethod("required",
            function(value, element) {
                return ! value ? false : true;
            },
            "Este campo es obligatorio"
        );

        jQuery.validator.addMethod("length", function (value, element, params) {
            return $(element).val().length == params;
        }, "Por favor, ingresar un valor de {0} de longitud.");


        jQuery.validator.addMethod("minlength", function (value, element, params) {
            return $(element).val().length >= params;
        }, "Por favor, ingresar un valor mayor a {0} caracteres.");

        jQuery.validator.addMethod("maxlength", function (value, element, params) {
            return $(element).val().length <= params;
        }, "Por favor, ingresar un valor menor a {0} caracteres.");

        jQuery.validator.addMethod("alphanumeric", function (value, element) {
            return this.optional(element) || /^[\w]+$/i.test(value);
        }, "Por favor, ingresar solo letras y números.");

        jQuery.validator.addMethod("emailCustomize", function (value, element) {
            return this.optional(element) || /^([a-zA-Z0-9_Ññ.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/i.test(value);
        }, "Por favor, ingresar una dirección de correo válida.");

        jQuery.validator.addMethod("celular", function (value, element) {
            return this.optional(element) || /^[9][0-9]{8}$/i.test(value);
        }, "Por favor, ingresar un número de celular valido de 9 digitos y que empiece con 9.");

        jQuery.validator.addMethod("decimal", function (value, element) {
            return this.optional(element) || /^\d*[.]?\d{0,2}$/.test(value);
        }, "Por favor, ingresar un número valido hasta 2 decimales (9.99).");
    });

</script>

</body>
</html>
