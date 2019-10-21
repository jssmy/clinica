<div class="col-sm-12">
    <label>Datos adicionales</label>
    <hr style="margin-top: 0px;">
    <label class="col-sm-4">Número de colegiatura</label>
    <div class="col-sm-8">
        <input  name="numero_colegiatura" type="text" value="{{isset($persona)? ( $persona->empleado? $persona->empleado->numero_colegiatura : '') : ''}}" class="form-control input-digits required">
    </div>
</div>
