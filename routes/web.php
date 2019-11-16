<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth.session'], function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('clinica.index');

    Route::group(['prefix' => 'tipo-seguro'], function() {
        Route::get('/', 'TipoSeguroController@index')->name('tipo-seguro.index');
        /**
         *Rutas para crear tipo de seguro
         */
        Route::get('/crear-form', 'TipoSeguroController@crearForm')->name('tipo-aseguro.crear-form');
        Route::post('/crear', 'TipoSeguroController@crear')->name('tipo-seguro.crear');

        /**
         *rutas para editar tipo de seguro
         */
        Route::get('/edidar-form/{tipo_id}', 'TipoSeguroController@editarForm')->name('tipo-seguro.editar-form');
        Route::put('/edidar/{tipo_id}', 'TipoSeguroController@editar')->name('tipo-seguro.editar');

        /**
         *Rutas para activar y desactivar tipos de seguro
         */
        Route::put('/edidar/{accion}/{tipo_id}', 'TipoSeguroController@editarEstado')->name('tipo-seguro.editar.estado');

    });

    Route::group(['prefix' => 'unidad-medida'], function() {
        Route::get('/', 'UnidadMedidaController@index')->name('unidad-medida.index');

        /**
         *Rutas para crear unidad de medida
         */
        Route::get('/crear-form', 'UnidadMedidaController@crearForm')->name('unidad-medida.crear-form');
        Route::post('/crear', 'UnidadMedidaController@crear')->name('unidad-medida.crear');

        /**
         *rutas para editar tipo de seguro
         */
        Route::get('/edidar-form/{unidad_id}', 'UnidadMedidaController@editarForm')->name('unidad-medida.editar-form');
        Route::put('/edidar/{unidad_id}', 'UnidadMedidaController@editar')->name('unidad-medida.editar');

        /**
         *Rutas para activar y desactivar tipos de seguro
         */
        Route::put('/edidar/{accion}/{tipo_id}', 'UnidadMedidaController@editarEstado')->name('unidad-medida.editar.estado');


    });

    Route::group(['prefix' => 'insumo'], function() {
        Route::get('/', 'InsumoController@index')->name('insumo.index');

        /**
         *Rutas para crear insumos
         */
        Route::get('/crear-form', 'InsumoController@crearForm')->name('insumo.crear-form');
        Route::post('/crear', 'InsumoController@crear')->name('insumo.crear');

        /**
         *rutas para editar insumos
         */
        Route::get('/edidar-form/{insumo_id}', 'InsumoController@editarForm')->name('insumo.editar-form');
        Route::put('/edidar/{insumo_id}', 'InsumoController@editar')->name('insumo.editar');

        /**
         *Rutas para activar y desactivar insumos
         */
        Route::put('/edidar/{accion}/{tipo_id}', 'InsumoController@editarEstado')->name('insumo.editar.estado');
    });


    Route::group(['prefix' => 'estado-civil'], function() {
        Route::get('/', 'EstadoCivilController@index')->name('estado-civil.index');

        /**
         *Rutas para crear estado
         */
        Route::get('/crear-form', 'EstadoCivilController@crearForm')->name('estado-civil.crear-form');
        Route::post('/crear', 'EstadoCivilController@crear')->name('estado-civil.crear');

        /**
         *rutas para editar estado
         */
        Route::get('/edidar-form/{estado_id}', 'EstadoCivilController@editarForm')->name('estado-civil.editar-form');
        Route::put('/edidar/{estado_id}', 'EstadoCivilController@editar')->name('estado-civil.editar');

        /**
         *Rutas para activar y desactivar estado
         */
        Route::put('/edidar/{accion}/{estado_id}', 'EstadoCivilController@editarEstado')->name('estado-civil.editar.estado');
    });

    Route::group(['prefix' => 'perfil'], function() {
        Route::get('/', 'PerfilController@index')->name('perfil.index');

        /**
         *Rutas para crear estado
         */
        Route::get('/crear-form', 'PerfilController@crearForm')->name('perfil.crear-form');
        Route::post('/crear', 'PerfilController@crear')->name('perfil.crear');

        /**
         *rutas para editar estado
         */
        Route::get('/edidar-form/{perfil}', 'PerfilController@editarForm')->name('perfil.editar-form');
        Route::put('/edidar/{perfil}', 'PerfilController@editar')->name('perfil.editar');

        /**
         *Rutas para activar y desactivar estado
         */
        Route::put('/edidar/{accion}/{tipo_id}', 'PerfilController@editarEstado')->name('perfil.editar.estado');
    });

    Route::group(['prefix' => 'examen-cab'], function() {
        Route::get('/', 'ExamenCabController@index')->name('examen-cab.index');

        /**
         *Rutas para crear examen cab
         */
        Route::get('/crear-form', 'ExamenCabController@crearForm')->name('examen-cab.crear-form');
        Route::post('/crear', 'ExamenCabController@crear')->name('examen-cab.crear');

        /**
         *rutas para editar examen cab
         */
        Route::get('/edidar-form/{perfil}', 'ExamenCabController@editarForm')->name('examen-cab.editar-form');
        Route::put('/edidar/{examenCab}', 'ExamenCabController@editar')->name('examen-cab.editar');

        /**
         *Rutas para activar y desactivar examen cab
         */
        Route::put('/edidar/{accion}/{tipo_id}', 'ExamenCabController@editarEstado')->name('examen-cab.editar.estado');

        /**
         * Submotivo
         */

        Route::get('obtener-submotivo/{motivo_id}','ExamenCabController@subMotivoList')->name('examen-cab.submotivo');
    });

    Route::group(['prefix' => 'examen-det'], function() {
        Route::get('/', 'ExamenDetController@index')->name('examen-det.index');

        /**
         *Rutas para crear examen det
         */
        Route::get('/crear-form', 'ExamenDetController@crearForm')->name('examen-det.crear-form');
        Route::post('/crear', 'ExamenDetController@crear')->name('examen-det.crear');

        /**
         *rutas para editar examen det
         */
        Route::get('/edidar-form/{perfil}', 'ExamenDetController@editarForm')->name('examen-det.editar-form');
        Route::put('/edidar/{examenDet}', 'ExamenDetController@editar')->name('examen-det.editar');

        /**
         *Rutas para activar y desactivar examen de
         */
        Route::put('/edidar/{accion}/{tipo_id}', 'ExamenDetController@editarEstado')->name('examen-det.editar.estado');
    });

    Route::group(['prefix' => 'persona'], function() {
        Route::get('/registro/', 'PersonaController@index')->name('persona.index');

        /**
         *Rutas para crear persona
         */
        Route::get('/crear-form/{tipo_persona}', 'PersonaController@crearForm')->name('persona.crear-form');
        Route::post('/crear', 'PersonaController@crear')->name('persona.crear');

        /**
         *rutas para editar persona
         */
        Route::get('/edidar-form/{tipo_persona}/{persona}', 'PersonaController@editarForm')->name('persona.editar-form');
        Route::put('/edidar/{persona}', 'PersonaController@editar')->name('persona.editar');

        /**
         *Rutas para activar y desactivar persona
         */
        Route::put('/edidar/{accion}/{tipo_id}', 'PersonaController@editarEstado')->name('persona.editar.estado');


        /**datos de persona**/
        Route::get('datos-personales/{tipo_persona}/{tipo_busqueda?}','PersonaController@datosPersonales')->name('persona.dato.personal');


        Route::get('lista/{paciente}','PersonaController@personas')->name('persona.lista');

        Route::get('lista/paciente',function (){
            return redirect()->route('persona.lista','paciente');
        })->name('persona.lista.paciente');

        Route::get('lista/medico',function (){
            return redirect()->route('persona.lista','medico');
        })->name('persona.lista.medico');

        Route::get('api/validar-dni/{numero_documento}','PersonaController@validarPersona')->name('persona.validar');

    });

    Route::group(['prefix' => 'usuario'], function() {
        Route::get('/', 'UsuarioController@index')->name('usuario.index');
        /**
         *Rutas para crear usuario
         */
        Route::get('/crear-form/', 'UsuarioController@crearForm')->name('usuario.crear-form');
        Route::post('/crear/{persona}', 'UsuarioController@crear')->name('usuario.crear');

        /**
         *rutas para editar persona
         */
        Route::get('/edidar-form/{usuario}', 'UsuarioController@editarForm')->name('usuario.editar-form');
        Route::put('/edidar/{persona}', 'UsuarioController@editar')->name('usuario.editar');

        /**
         *Rutas para activar y desactivar persona
         */
        Route::put('/edidar/{accion}/{tipo_id}', 'UsuarioController@editarEstado')->name('usuario.editar.estado');


        /**datos de persona**/
        Route::get('datos-personales/{tipo_persona}','UsuarioController@datosPersonales')->name('usuario.dato.personal');

        /** gestion de personas **/

        Route::put('resetear/{usuario}','UsuarioController@resetear')->name('usuario.resetear');
        Route::put('actualizar-estado/{usuario}','UsuarioController@resetear')->name('usuario.actualizar-estado');


    });

    Route::group(['prefix' => 'registro-analisis'], function() {
        Route::get('/', 'RegistroAnalisisController@index')->name('registro-analisis.index');
        Route::get('/resultado',function (){
            return redirect()->route('registro-analisis.index','resultado=true');
        })->name('registro.resultado');

        /**
         *Rutas para crear analisis
         */
        Route::get('/crear-form/{persona}', 'RegistroAnalisisController@crearForm')->name('registro-analisis.crear-form');
        Route::post('/crear', 'RegistroAnalisisController@crear')->name('registro-analisis.crear');

        /**
         *rutas para editar analisis
         */
        Route::get('/edidar-form/{persona}', 'RegistroAnalisisController@editarForm')->name('registro-analisis.editar-form');
        Route::put('/edidar/{persona}', 'RegistroAnalisisController@editar')->name('registro-analisis.editar');

        /**
         *Rutas para activar y desactivar analisis
         */
        Route::put('/edidar/{accion}/{tipo_id}', 'RegistroAnalisisController@editarEstado')->name('registro-analisis.editar.estado');

        Route::get('registro-contrar-persona/{tipo}/{numero_documento}','RegistroAnalisisController@encontrarPersona')->name('registro.encontrar-presona');

        Route::get('load-analisis/{persona}','RegistroAnalisisController@analisisTable')->name('load.analisis.table');

        /** obtener resultados de analisis**/
        Route::get('/{analisis_id}/resultados','RegistroAnalisisController@resultadosAnalisis')->name('registro.analisis.resultados');

        /** obtener resultados de analisis**/
        Route::get('/{analisis}/cambiar','RegistroAnalisisController@cambiarPacienteForm')->name('registro.analisis.cambiar');

        /** obtener resultados de analisis store**/
        Route::put('/{analisis}/cambiar/store','RegistroAnalisisController@cambiarPacienteStore')->name('registro.analisis.cambiar.store');

        /** gurdar resultados**/
        Route::put('/guardar-resultados/{analisis}','RegistroAnalisisController@guardarResultadoAnalisis')->name('registro.analisis.guardar-resultado');

        Route::get('imprimir-documento/{analisis}','RegistroAnalisisController@imprimir')->name('registro.analsis.imprimir');

        Route::get('semaforo-form','RegistroAnalisisController@semoforizacionForm')->name('registro.analisis.semaforo-form');

        Route::put('semaforo-store','RegistroAnalisisController@semoforizacionStore')->name('registro.analisis.semaforo-store');



    });

    Route::group(['prefix' => 'dashboard'], function() {
        //Route::get('/main/{tipo_reporte}/{tipo_persona?}','DashboardController@index')->name('dashboard.index');

        Route::get('/mostrar-reporte/{persona}/{tipo_reporte}','DashboardController@mostrarReporte')->name('dashboard.mostrar-reporte');
        Route::get('stock-insumo','DashboardController@reporteStockInsumo')->name('dashboard.stock-insumo');
        Route::get('tiempo-atencion','DashboardController@reportePromedioAtencion')->name('dashboard.tiempo-atencion');
        Route::get('patologia-anormal','DashboardController@reportePatologiaAnormal')->name('dashboard.patologia-anormal');

        Route::get('paciente-atendido','DashboardController@pacienteAtendido')->name('dashboard.paciente-atendido');

        Route::get('profesional-medico','DashboardController@profesionalMedico')->name('dashboard.profesional-medico');
        Route::get('prefesional-medico-reporte/{persona}','DashboardController@reporteMedicoExamenesEmitidos')->name('dashboard.profesional-medico-reporte');
        Route::get('profesional-medico-tecnologo',function (){
            return redirect()->route('dashboard.profesional-medico',['tecnologo=true']);
        })->name('dashboard.profesional-medico-tecnologo');

        Route::get('produccion-mensual','@produccionMensual')->name('dashboard.produccion-mensual');
        Route::get('download-paciente-atendido/{paciente_id}','DashboardController@downloadReportePacienteAtendido')->name('dashboard.download-paciente-atendido');
        Route::get('download-prefesional-medico/{persona}','DashboardController@downloadPrefesionalMedico')->name('dashboard.download-profesional-medico');
        Route::get('download-stock-insumo','DashboardController@donwloadStockInsumo')->name('dashboard.download-stock-insumo');
        Route::get('download-tiempo-atencion','DashboardController@downloadPromedioAtencion')->name('dashboard.download-tiempo-atencion');
    });

    Route::group(['prefix'=>'mail'],function (){
        Route::get('envio-automatico/recuperar-contrasena','MailController@send');
    });

});

Route::get('iniciar-sesion','AuthController@loginForm')->name('login-form');

Route::post('iniciar-sesion-store','AuthController@login')->name('login.store');

Route::post('cerrar-sesion','AuthController@logout')->name('logout.store');
