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

Route::get('/', function () {
    return view('welcome');
});

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
    Route::get('/', 'PersonaController@index')->name('persona.index');

    /**
     *Rutas para crear persona
     */
    Route::get('/crear-form', 'PersonaController@crearForm')->name('persona.crear-form');
    Route::post('/crear', 'PersonaController@crear')->name('persona.crear');

    /**
     *rutas para editar persona
     */
    Route::get('/edidar-form/{persona}', 'PersonaController@editarForm')->name('persona.editar-form');
    Route::put('/edidar/{persona}', 'PersonaController@editar')->name('persona.editar');

    /**
     *Rutas para activar y desactivar persona
     */
    Route::put('/edidar/{accion}/{tipo_id}', 'PersonaController@editarEstado')->name('persona.editar.estado');
});

Route::group(['prefix' => 'registro-analisis'], function() {
    Route::get('/', 'RegistroAnalisisController@index')->name('registro-analisis.index');

    /**
     *Rutas para crear analisis
     */
    Route::get('/crear-form', 'RegistroAnalisisController@crearForm')->name('registro-analisis.crear-form');
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


});
