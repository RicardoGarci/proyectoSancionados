@extends('layouts.app')
@section('content')

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Sancionados
                            <small class="font-13 "> Agregar Sancionado</small></h4>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('sancionados.store') }}">
                @csrf
                <div class="timeline-alt py-0">
                    <div class="timeline-item">
                        <i class="ri-user-add-line bg-primary-lighten text-primary timeline-icon"></i>
                        <div class="timeline-item-info">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Nombre(s)<small class="text-danger">*</small></label>
                                                <input name="txtNombreCompleto" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Apellidos<small class="text-danger">*</small></label>
                                                <input name="txtApellidos" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Curp<small class="text-danger">*</small></label>
                                                <input name="txtCurp" type="text" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">RFC<small class="text-danger">*</small></label>
                                                <input name="txtRFC" type="text" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                            <div align="left">
                                <button type="button" id="agregar-sancion" class="btn btn-success"
                                    <span>Agregar Sancion</span>
                                </button>
                            </div><br>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <i class="ri-file-list-3-line bg-primary-lighten text-primary timeline-icon"></i>
                        <div class="timeline-item-info">
                            <div id="sanciones-adicionales">
                                <div class="sancion">
                                    <div class="card">
                                        <div class="card-body">
            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Numero De Expediente<small class="text-danger">*</small></label>
                                                        <input name="sanciones_adicionales[0][txtNExpediente]" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Cargo del Servidor Publico<small class="text-danger">*</small></label>
                                                        <input name="sanciones_adicionales[0][txtCargoServidorPublico]" type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Monto De La Sanción</label>
                                                        <input  name="sanciones_adicionales[0][txtMonto]" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label"> Duracion De La Resolución</label>
                                                        <input name="sanciones_adicionales[0][txtDResolucion]" type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Fecha De Resolución<small class="text-danger">*</small></label>
                                                        <input name="sanciones_adicionales[0][dateResolucion]"type="date" class="form-control ">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Fecha De Inicio</label>
                                                        <input name="sanciones_adicionales[0][dateInicio]"type="date" class="form-control ">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3 date">
                                                        <label class="form-label">Fecha De Termino</label>
                                                        <input name="sanciones_adicionales[0][dateTermino]" type="date" class="form-control ">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div  class="mb-3">
                                                        <label for="" class="ms-0">Autoridad<small class="text-danger">*</small></label>
                                                        <select name="sanciones_adicionales[0][slcAutoridad]" class="form-control"  >
                                                            <option value="">Seleccione una opción</option>
                                                        @foreach ($autoridades as $autoridad)
                                                            <option value="{{ $autoridad->id_catalogo_autoridades }}">{{ $autoridad->nombre_autoridad }}</option>
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div  class="mb-3">
                                                        <label for="" class="ms-0">Sanción<small class="text-danger">*</small></label>
                                                        <select name="sanciones_adicionales[0][slcSancion]" class="form-control" >
                                                            <option value="">Seleccione una opción</option>
                                                            @foreach ($sanciones as $sancion)
                                                            <option value="{{ $sancion->id_catalogo_sanciones }}">{{ $sancion->nombre_sancion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div  class="mb-3">
                                                        <label for="" class="ms-0">Dependencia<small class="text-danger">*</small></label>
                                                        <select name="sanciones_adicionales[0][slcDependencia]" class="form-control" >
                                                            <option value="">Seleccione una opción</option>
                                                            @foreach ($dependencias as $dependencia)
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
                                                        {{-- <input name="sanciones_adicionales[0][txtObservaciones]" type="text-area" class="form-control"> --}}
                                                        <textarea name="sanciones_adicionales[0][txtObservaciones]" rows="5" class="form-control"></textarea>
                                                        </div>
                                                </div>
                                            </div>
            
                                        </div>
                                    </div>
                                    <button class="quitar-sancion btn btn btn-primary rounded-pill " style="display: none;">
                                        <i class="ri-delete-bin-2-fill"></i>
                                    </button>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div align="right">
                    <button type="submit" class="btn btn-primary" >Agregar
                        <i class="fas fa-plus"></i></button>
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



    $(document).ready(function() {
        let sancionIndex = 0;

        // Agregar sanción
        $('#agregar-sancion')
            .click(function() {
        sancionIndex++;
        const nuevaSancion = $('#sanciones-adicionales .sancion:first').clone();

        nuevaSancion.find('input, select, textarea').each(function() {
            const input = $(this);
            const name = input.attr('name').replace('[0]', `[${sancionIndex}]`);
            input.attr('name', name).val('');
        });


        if (sancionIndex > 0) {
            // Agregar botón de "Quitar Sanción" solo a partir de la segunda sanción
            nuevaSancion.find('.quitar-sancion').show();
        } else {
            // Si es el primer card, eliminar el botón "Quitar Sanción" (si existe)
            nuevaSancion.find('.quitar-sancion').remove();
        }

        $('#sanciones-adicionales').append(nuevaSancion);
  
        });

        // Quitar sanción
        $('#sanciones-adicionales').on('click', '.quitar-sancion', function() {
        $(this).parent('.sancion').remove();
        });
    });

</script>
@endsection
