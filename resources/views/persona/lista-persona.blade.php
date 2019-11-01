@extends('layouts.app')
@section('title','Personas')
@section('content')
    <section id="search-section" >
        <!-- title row -->

        <div class="row">
            <div style="padding-bottom: 24px" class="text-center">
                <span class="page-header text-info"  style="font-size: 37px; color: #337ab7;">
                    <i class="fa fa-search"></i> Buscar {{$tipo_persona=='paciente' ? 'Paciente' : 'Médico'}}
                </span>
            </div>
        </div>
        <!-- info row -->
        <div class="row">
            <div style=" display: flex; justify-content: center;">
                <div style="min-width: 300px; width: 50%" class="invoice-col">
                    <div class="input-group input-group-lg">
                        <div class="input-group-btn">

                            <button class="btn btn-default" style="color: #fff;background: #31708f;font-size: 14px;" >Nro. documento</button>

                        </div>
                        <!-- /btn-group -->
                        <input data-btn="btn-consultar" id="txt-numero" type="text" name="numero" class="input-submit form-control input-digits" placeholder="buscar {{$tipo_persona=='paciente' ? 'paciente' : 'médico'}}">
                        <div class="input-group-btn">
                            <button id="btn-consultar"
                                    data-search="<span class='fa fa-search' style='color: #fff;background: #31708f;'></span>"
                                    data-loading="<i class='fa fa-circle-o-notch fa-spin'></i> Buscando"
                                    class="btn btn-default"
                                    data-url="{{route('persona.dato.personal',$tipo_persona)}}"
                                    title="buscar..." style="color: #fff;background: #31708f; font-size: 15px">
                                <span class="fa fa-search" style="color: #fff;background: #31708f;"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <div id="message">

        </div>
    </section>
    <div id="main-section"  style="padding-top: 0px; background: transparent; border: 0px;">
    </div>
    <section id="tbl-personas">
        @include('persona.partials.persona-table')
    </section>

@endsection
@section('scripts')
    <script src="{{URL::asset('public/plugins/bootbox/bootbox.min.js')}}"></script>
    <script>
        var url_index ="{{route('persona.lista',$tipo_persona)}}";

        var params={};
        $(document).on('click','#btn-consultar', function () {

            if ($("#txt-numero").val() == ""){
                return false;
            }
            var url = $(this).data('url');

            $('#message').html('');
            var btn = $(this);
            params.numero_documento = $("#txt-numero").val();
            params.section='edit_persona';
            $.ajax({
                url: url,
                type: 'get',
                data: params,
                success: function (view){
                    $("#main-section").html(view);
                    $('#main-section').fadeIn();
                    $('#search-section').fadeOut();
                    params.persona = JSON.parse($("#hdh-persona").val());
                    params.buscar_numero_documento=true;
                    console.log(params);
                    load_table();
                },
                beforeSend: function(){
                    btn.html("<i class='fa fa-circle-o-notch fa-spin'></i> Buscando");
                    btn.attr('disabled', true);

                },
                complete: function(){
                    btn.html('<span class="fa fa-search" style="color: #fff;background: #31708f;"></span>');
                    btn.removeAttr('disabled');
                }
            });
        });

        $(document).on("click","a", function (e) {

            if($(this).parent().parent().hasClass('pagination')){
                if($(this).hasClass('disabled')) return  false;
                $(this).addClass('disabled');
                load_table($(this).attr('href'));
                return false;
            }

        });
        function load_table(url){
            var url_temp = url ? url : url_index;
            $.ajax({
                url: url_temp,
                type:'get',
                data : params,
                success: function (view) {
                    $("#tbl-personas").html(view);
                    params={};
                }
            });
        }
    </script>
@endsection
