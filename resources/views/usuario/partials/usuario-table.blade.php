<div class="row">
    <div class="col-sm-12">
        <table class="table table-hover table-striped" style="font-size:13px;">
            <thead style="background-color: #3c8dbc; color: white">
            <tr>
                <th>Usuario</th>
                <th>Perfil</th>
                <th>DNI</th>
                <th>Médico</th>
                <th>Usuario registro</th>
                <th>Fecha registro</th>
            </tr>
            </thead>
            <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{$usuario->usuario}}</td>
                    <td>{{$usuario->perfil->descripcion}}</td>
                    <td>{{$usuario->persona->numero_documento}}</td>
                    <td>{{$usuario->persona->nombre_completo}}</td>
                    <td>{{$usuario->usuario_registro->usuario}}</td>
                    <td>{{$usuario->fecha_registro}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
