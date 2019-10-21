<div class="row">
    <div class="col-sm-12">
        <input id="hdn-token" type="hidden" value="{{ csrf_token() }}">
        <input id="hdh-persona" type="hidden" value="{{json_encode($persona)}}">
        @include('persona.partials.datos-personales')
    </div>
</div>

<div   class="row" style="margin-top: 15px">
    <div id="registros-analisis" class="col-sm-12"></div>
</div>
