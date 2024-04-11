
@extends('layouts.app')
@section('content')

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Sancionados
                            <small class="font-13 "> Editar Sancionado</small></h4>
                    </div>
                </div>
            </div>
            {{--se llena el select picker con las personas sancionadas para la busqueda--}}
            <form action="{{ route('sancionados.cargarDatos') }}" method="POST">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div class="input-group mb-2">
                            <div class="input-group-text"><i class="ri-search-eye-line"></i></div>
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre...">
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="input-group mb-2">
                            <div class="mb-3">
                                <select name="id_persona_sancionada" id="personaSancionada" class="form-control">
                                    <option value="">Seleccione una opción</option>
                                    @foreach ($personasSancionadas as $personaSancionada)
                                        <option value="{{ $personaSancionada->id_persona_sancionada}}">
                                            {{ $personaSancionada->nombre_completo}} CURP:{{ $personaSancionada->curp}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" id="cargarDatosBtn" name="accion" value="cargar" class="btn btn-primary mb-2 rounded-pill">
                            <i class="ri-article-line"></i>
                            Cargar Datos
                        </button>
                    </div>
                </div>
                

                <div class="row justify-content-center ">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Nombre(s)<small class="text-danger">*</small></label>
                                    <input value="{{ collect($personasInfo)->first()['nombre_completo'] ?? '' }}" name="txtEditNombreCompleto" type="text" class="form-control" >
                                    <input type="hidden" name="idPersonaS" value="{{ collect($personasInfo)->first()['id_persona_sancionada'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Apellidos<small class="text-danger">*</small></label>
                                    <input value="{{ collect($personasInfo)->first()['apellidos'] ?? '' }}" name="txtEditApellidos" type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">CURP<small class="text-danger">*</small></label>
                                    <input value="{{ collect($personasInfo)->first()['curp'] ?? '' }}" name="txtEditCurp" type="text" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">RFC<small class="text-danger">*</small></label>
                                    <input value="{{ collect($personasInfo)->first()['rfc'] ?? '' }}" name="txtEditRFC" type="text" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-10">
                        @php
                            $index=0;// Inicializamos el índice para las sanciones cargadas inicialmente
                        @endphp
                        @foreach ($personasInfo as $c)
                            <div id="sanciones-adicionalesEdit">
                                <div class="sancionEdit">
                                    <div class="card" >
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Numero De Expediente </label>
                                                        <input type="hidden" name="sanciones_adicionalesEdit[{{ $index }}][idSancionadoEdit]" value="{{ $c->id_sancionado }}">
                                                        <input value="{{ $c->numero_expediente }}" name="sanciones_adicionalesEdit[{{ $index }}][txtEditNExpediente]" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Cargo del Servidor Publico<small class="text-danger">*</small></label>
                                                        <input value="{{ $c->cargo_servidor_publico }}" name="sanciones_adicionalesEdit[{{ $index }}][txtEditCargoServidorPublico]" type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Monto De La Sanción</label>
                                                        <input value="{{ $c->monto }}" name="sanciones_adicionalesEdit[{{ $index }}][txtEditMonto]" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label"> Duracion De La Resolución</label>
                                                        <input value="{{ $c->duracion_resolucion }}" name="sanciones_adicionalesEdit[{{ $index }}][txtEditDResolucion]" type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Fecha De Resolución<small class="text-danger">*</small></label>
                                                        <input value="{{ date('Y-m-d', strtotime($c->fecha_resolucion)) }}" name="sanciones_adicionalesEdit[{{ $index }}][dateEditResolucion]" type="date" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Fecha De Inicio</label>
                                                        @php
                                                            $fechaInicio = ($c->fecha_inicio && $c->fecha_inicio != '1970-01-01') ? date('Y-m-d', strtotime($c->fecha_inicio)) : '';
                                                        @endphp
                                                        <input value="{{ $fechaInicio }}" name="sanciones_adicionalesEdit[{{ $index }}][dateEditInicio]" type="date" class="form-control">
                                                    </div>                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Fecha De Termino</label>
                                                        @php
                                                            $fechaTermino = ($c->fecha_termino && $c->fecha_termino != '1970-01-01') ? date('Y-m-d', strtotime($c->fecha_termino)) : '';
                                                        @endphp
                                                        <input value="{{ $fechaTermino }}" name="sanciones_adicionalesEdit[{{ $index }}][dateEditTermino]" type="date" class="form-control">
                                                    </div>                                                    
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div  class="mb-3">
                                                        <label for="" class="ms-0">Autoridad<small class="text-danger">*</small></label>
                                                        <select name="sanciones_adicionalesEdit[{{ $index }}][slcEditAutoridad]" class="form-control"  >
                                                            <option value="{{ $c->id_catalogo_autoridades }}">{{ $c->nombre_autoridad }}</option>
                                                            @foreach ($autoridadesEdit as $autoridad)
                                                                <option value="{{ $autoridad->id_catalogo_autoridades }}">{{ $autoridad->nombre_autoridad }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div  class="mb-3">
                                                        <label for="" class="ms-0">Sanción<small class="text-danger">*</small></label>
                                                        <select name="sanciones_adicionalesEdit[{{ $index }}][slcEditSancion]" class="form-control" >
                                                            <option value="{{ $c->id_catalogo_sancionados }}">{{ $c->nombre_sancion }}</option>
                                                            @foreach ($sancionesEdit as $sancion)
                                                                <option value="{{ $sancion->id_catalogo_sanciones }}">{{ $sancion->nombre_sancion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div  class="mb-3">
                                                        <label for="" class="ms-0">Dependencia<small class="text-danger">*</small></label>
                                                        <select name="sanciones_adicionalesEdit[{{ $index }}][slcEditDependencia]" class="form-control" >
                                                            <option value="{{ $c->id_catalogo_dependencia }}">{{ $c->nombre_dependencia }}</option>
                                                            @foreach ($dependenciasEdit as $dependencia)
                                                                <option value="{{ $dependencia->id_catalogo_dependecia }}">{{ $dependencia->nombre_dependencia }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Observaciones</label>
                                                        {{--<input value="{{ $c->observaciones }}" name="sanciones_adicionalesEdit[{{ $index }}][txtEditObservaciones]" type="text-area" class="form-control" rows='5'>--}}
                                                        <textarea  name="sanciones_adicionalesEdit[{{ $index }}][txtEditObservaciones]"  class="form-control" rows='5'>{{ $c->observaciones }}</textarea> 
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="quitar-sancionEditNuevo btn btn-primary rounded-pill " style="display: none;">
                                        <i class="ri-delete-bin-2-fill"></i>
                                    </button>
                                </div>
                            </div>
                            @php
                                $index++;// Inicializamos el índice para las sanciones cargadas inicialmente
                            @endphp
                        @endforeach
                    </div>
                </div>
                <div align="left">
                    <button type="button" id="agregar-sancionEditNuevo" class="btn btn-success">Agregar Sancion</button>
                </div>
                <div id="sanciones-adicionalesEditNuevos"></div>
                <div align="right">
                    <button type="submit" class="btn btn-primary" name="accion" value="guardar" >Guardar</button>
                </div>                           
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const status = {{ session('status') ?? 0 }};
    const errors = @json(session('mensaje'));
        if (status === 200) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('mensaje') }}',
            });
        } else if (status === 500) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('mensaje') }}',
            });
        } else if (status === 400) {
            let errorMessage = '';

            if (errors) {
                for (const field in errors) {
                    errorMessage += `${errors[field].join(', ')}<br>`;
                }
            }
            Swal.fire({
                icon: 'info',
                title: 'Error',
                html: errorMessage,
            });
        }
    });
    //control  de busqueda de personas ,con el buscador puesto en la parte superior de sancionados
    document.getElementById('searchInput').addEventListener('input', function() {
        var input, filter, select, options, option, i;
        input = this;
        filter = input.value.toUpperCase();
        select = document.getElementById('personaSancionada');
        options = select.getElementsByTagName('option');

        for (i = 0; i < options.length; i++) {
            option = options[i];
            if (option.text.toUpperCase().indexOf(filter) > -1) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        }
    });
    //se crea y se elimina el card de una nueva sancion que se crea en el div sanciones-adicionalesEditNuevos
    $(document).ready(function () {
    let sancionIndex = {{ $index }}; 
        $('#agregar-sancionEditNuevo').click(function () {
            sancionIndex++;
            const nuevaSancion = $('#sanciones-adicionalesEdit .sancionEdit:first').clone();

            nuevaSancion.find('input, select, textarea').each(function () {
                const input = $(this);
                const name = input.attr('name');
                // Modificamos el name agregando el índice actual
                input.attr('name', name.replace(/\[\d+\]/g, `[${sancionIndex}]`)).val('');
            });

            if (sancionIndex > 0) {
                nuevaSancion.find('.quitar-sancionEditNuevo').show();
            } else {
                nuevaSancion.find('.quitar-sancionEditNuevo').remove();
            }

            $('#sanciones-adicionalesEditNuevos').append(nuevaSancion);
            
        });
        $('#sanciones-adicionalesEditNuevos').on('click', '.quitar-sancionEditNuevo', function () {
            $(this).parent('.sancionEdit').remove();
        });
    });

</script>
@endsection

