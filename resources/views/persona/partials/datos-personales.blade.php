<input type="hidden" name="{{$persona->es_paciente ? 'paciente_id' : 'medico_id'}}" value="{{$persona->id}}">
<div style="margin-bottom: 0px">
    <span style="font-size: 40px; color: #337ab7"> {{ $persona->nombre_completo}} </span>
</div>

<div class="tab-content" style="background: white; margin-top: 0px;">
    <div style="display: flex;">
        <div id="home" class="fade in active content-section" style="display: flex; flex-direction: column; justify-content: space-between; flex:2; margin-right: 3px; background: #f8f8f8; border-radius: 11px;">
            <div style="display: flex; height: 100%">
                <div class="invoice-col" style=" border-right: 1px solid #dad9d9f7; display: flex; min-width: 200px;  justify-content: center; align-items: center">
                    <div style="display: flex; flex-direction: column;">
                        <div style="display: flex; flex-direction: row;">
                            <div class="text-center" style="padding: 10px">
                                <div class="text-center" style="padding: 5px">
                                    <span class="success">
                                        <b><i class="fa fa-5x {{!$persona->es_paciente ? 'fa-user-md' : 'fa-stethoscope'}}"></i></b>
                                        <br>
                                        <b>{{$persona->es_paciente ? 'PACIENTE' : 'MÉDICO'}}</b>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display: flex; flex: 1; flex-direction: column;  justify-content: space-around;">
                    <div style="display: flex">
                        <div class="invoice-col" style="padding:10px; ">
                            <div style="padding-top: 5px">
                                <span style="color: #606060; font-weight: bold;">Nro. Documento:</span>
                                <span style="color: rgba(33, 32, 36, 0.52)">{{$persona->numero_documento}}</span>
                            </div>
                            @if($persona->es_paciente)
                            <div style="padding-top: 5px">
                                <span style="color: #606060; font-weight: bold;">Nro. Historia clínica:
                                </span>
                                <span style="color: rgba(33, 32, 36, 0.52)">{{ $persona->paciente ?  $persona->paciente->numero_historia_clinica : '-'}}</span>
                            </div>
                            @else
                                <div style="padding-top: 5px">
                                <span style="color: #606060; font-weight: bold;">Nro. Colegiatura:
                                </span>
                                    <span style="color: rgba(33, 32, 36, 0.52)">{{$persona->medico ? $persona->medico->numero_colegiatura : '-'}}</span>
                                </div>
                            @endif
                            <div style="padding-top: 5px">
                                <span style="color: #606060; font-weight: bold;">Teléfono:</span>
                                <span style="color: rgba(33, 32, 36, 0.52)">{{$persona->telefono}}</span>
                            </div>
                        </div>
                        <div class="invoice-col" style="padding:10px;">
                            <div style="padding-top: 5px">
                                <span style="color: #606060; font-weight: bold;">Dirección :</span>
                                <span style="color: rgba(33, 32, 36, 0.52)">{{$persona->direccion}}</span>
                            </div>
                            <div style="padding-top: 5px">
                                <span style="color: #606060; font-weight: bold;">Fecha nacimiento :</span>
                                <span style="color: rgba(33, 32, 36, 0.52)">{{$persona->fec_nacimiento->format('d/m/Y')}}</span>
                            </div>
                            <div style="padding-top: 5px">
                                <span style="color: #606060; font-weight: bold;">Fecha de registro :</span>
                                <span style="color: rgba(33, 32, 36, 0.52)">{{$persona->fec_registro->format('d/m/Y')}}</span>
                            </div>
                        </div>
                    </div>

                        <div style="display: flex;">
                        <div style="display: flex; padding:10px; align-content: flex-end; align-items: flex-end;" class="text-center">
                            <div>
                                @if(request()->section=='edit_persona')
                                <a style="margin-right: 30px" href="#"><i class="fa fa-user"></i> Editar datos personales</a>
                                @endif
                                @if(!in_array(request()->section,['registro_analisis']))
                                    <a href="#" id="btn-limpiar"><i class="fa fa-remove"></i> Limpiar</a>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @if(request()->section=='edit_person')
        <div id="content-ultimo-recibo"
             class="fade in active content-section"
             style="flex:1; background: #f8f8f8; border-radius: 11px; max-width: 300px;">
            <div style="display: flex; flex-direction: column; justify-content: center; padding: 10px">
                <div style="display: flex; align-items: center; justify-content: center; color: #7d7c7c;">
                    <div>
                        <span>Últimas acciones</span>
                    </div>
                </div>
                <div style="display: flex; justify-content: center; margin-top: 10px;">
                    <div>

                    </div>
                </div>

            </div>
        </div>
        @endif
    </div>
</div>



