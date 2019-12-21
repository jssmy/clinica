<form id="form-store" action="{{route('registro.analisis.semaforo-store')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="col-sm-12">
            <table class="table">
                <thead>
                <tr>
                    <td>Color</td>
                    <td>Descripcion</td>
                    <td>Valor inicio</td>
                    <td>Valor final</td>
                </tr>
                </thead>
                <tbody>
                    @foreach($semaforizacion as $semaforo)
                        <tr>
                            <td style="background-color: {{$semaforo->color}}">
                                <input type="hidden" name="semaforo[{{$semaforo->id}}][color]" value="{{$semaforo->color}}">
                            </td>
                            <td><input class="form-control required" name="semaforo[{{$semaforo->id}}][descripcion]" value="{{$semaforo->descripcion}}"></td>
                            <td><input maxlength="9" class="form-control required input-digits" name="semaforo[{{$semaforo->id}}][rango_inicio]" value="{{$semaforo->rango_inicio}}"></td>
                            <td><input maxlength="9" class="form-control required input-digits" name="semaforo[{{$semaforo->id}}][rango_fin]" value="{{$semaforo->rango_fin}}"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</form>
<script>
    $(".input-digits").inputFilter(function (value) {
        return format_digits(value);
    });
</script>
