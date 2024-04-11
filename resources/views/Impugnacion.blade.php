@extends('layouts.app')
@section('content')

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Impugnación</h4>
                    </div>
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane show active" >
                    <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre Completo</th>
                                <th>CURP</th>
                                <th>Sancion</th>
                                <th>Dependencia</th>
                                <th>Autoridad</th>
                                <th>Fecha Resolución</th>
                                <th>Numero De Expediente</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sancionadosInfo as $item)


                                <tr>
                                    <td>{{ $item['nombre_completo'] }} {{  $item['apellidos'] }} </td>
                                    <td>{{ $item['curp'] }} </td>
                                    <td>{{ $item['nombre_sancion'] }} </td>
                                    <td>{{ $item['nombre_dependencia'] }} </td>
                                    <td>{{ $item['nombre_autoridad'] }} </td>
                                    <td>{{ $item['fecha_resolucion'] }} </td>
                                    <td>{{ $item['numero_expediente'] }} </td>
                                    <td>
                                        @if ($item->impugnada)
                                            @if (Auth::user()->super() or Auth::user()->administrador() or Auth::user()->capturista() or Auth::user()->consulta())
                                            <button class="btn btn-soft-secondary" 
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDoc{{ $item->id_sancionado }}" 
                                                    onclick="loadDocumentosImpugnacion({{ $item->id_sancionado }})">
                                                <i class="ri-folder-open-fill"></i>
                                            </button>
                                            @endif
                                        <!-- modal documentacion -->
                                        <div id="modalDoc{{ $item->id_sancionado }}" class="modal fade" tabindex="-1"  role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-full-width">
                                                <div class="modal-content ">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" > Documentos Descargables De Impugnaciones </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="table-responsive">
                                                            <table id="listadocumentos{{ $item->id_sancionado }}" class="table dt-responsive nowrap w-100">
                                                                <thead class="table-dark">
                                                                    <tr>
                                                                        <th class="columna-fecha" style="text-align: center;">Fecha Resolución  </th>
                                                                        <th class="columna-expediente" style="text-align: center;">Número Expediente</th>
                                                                        <th class="columna-observacion" style="text-align: center;">Observación</th>
                                                                        <th class="columna-descargar" style="text-align: center;">Archivo Descargable</th>
                                                                        <th class="columna-creacion" style="text-align: center;">Fecha Creación</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    
                                                    </div>                                       
                                                </div>
                                            </div>
                                        </div>
                                        <!-- fin de modal documentacion  -->  
                                        @endif
                                        @if (Auth::user()->super() or Auth::user()->administrador() )
                                            @if($item['deprecated'] == 0)
                                                <button class="btn btn-soft-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalImpugnar{{ $item['id_sancionado'] }}" >
                                                    <i class="ri-bank-line"></i>
                                                </button>
                                            @else
                                            <button class="btn btn-soft-success" 
                                                    id="{{ $item['id_sancionado'] }}"
                                                    onclick="window.location='{{ route("impugnar.activar", ["id" => $item['id_sancionado']]) }}'"
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    data-bs-title="Activar Sanción">
                                                <i class="ri-auction-fill"></i>
                                            </button>
                                            @endif
                                        @endif

                                        
                                    </td>
                                </tr>
                                <!-- Modal de Impugnar -->
                                <div id="modalImpugnar{{ $item['id_sancionado'] }}" class="modal fade" tabindex="-1" aria-labelledby="modalImpugnarLabel{{ $item['id_sancionado'] }}" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content ">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="modalImpugnarLabel{{ $item['id_sancionado'] }}" > Impugnar </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('impugnar.agregar') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_sancionado" value="{{ $item['id_sancionado'] }}">
                                                    <input type="hidden" name="id_impugnacion" value="">
                 
                                                    <div class="mb-3">
                                                        <label  class="form-label">Tipo de Inpugnacion:</label>
                                                        <input name="tipoInpugnacion" type="text" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Fecha De Resolución:</label>
                                                        <input name="fechaResolucion" type="date" class="form-control ">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Numero De Expediente:</label>
                                                        <input name="numeroExpediente" type="text" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Observaciones</label>
                                                        <textarea name="observacionesInpugnacion" rows="5" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button  type="submit" class="btn btn-primary">Impugnar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--final modal impugnar --> 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

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
            Swal.fire({
                icon: 'info',
                title: 'Error',
                text: '{{ session('mensaje') }}',
            });
        }
    });

    function loadDocumentosImpugnacion(idSancionado) {
    $.ajax({
        type: 'GET',
        url: '{{ route("impugnar.loadDocumentosImpugnacion", ["id_sancionado" => "__id_sancionado__"]) }}'.replace('__id_sancionado__', idSancionado),
        data: {
            id_sancionado: idSancionado
        },
        success: function(response) {
            // Limpiar la tabla antes de agregar nuevos datos
            var tableBody = $('#listadocumentos' + idSancionado).find('tbody');
            tableBody.empty();

            // Recorrer los datos y agregarlos a la tabla
            response.forEach(function(item) {
                var newRow = '<tr>' +
                    '<td>' + item.fecha_resolucion + '</td>' +
                    '<td>' + item.numero_expediente + '</td>' +
                    '<td>' +
                    '<textarea rows="5" class="form-control">' + item.observacion + '</textarea></td>' +
                    '<td>' +
                    '<a href="{{ route("impugnarPDF", ":id") }}" class="btn btn-primary d-flex align-items-center" target="_blank">' + 
                    '<i class="ri-file-download-line"></i>' +
                    ' Ver/Descargar' +
                    '</a>' +
                    '</td>' +
                    '<td>' + item.fecha_creacion + '</td>' +
                    '</tr>';
                newRow = newRow.replace(':id', item.id_observacion); // Reemplazar :id con el ID del documento
                tableBody.append(newRow);
            });

            // Destruir la instancia de DataTable existente
            var dataTable = $('#listadocumentos' + idSancionado).DataTable();
            if (dataTable) {
                dataTable.destroy();
            }

            // Volver a inicializar DataTable después de agregar filas
            $('#listadocumentos' + idSancionado).DataTable({
               
                columnDefs: [
                    { orderable: true, targets: [0, 1, 4] },  
                    { orderable: false, targets: [2,3 ]}  
                ]
            });
           
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Error al cargar los documentos de impugnación.');
        }
    });
}

    $(document).ready(function() {
        @foreach ($sancionadosInfo as $item)
            $("#modalImpugnar{{ $item['id_sancionado'] }}").on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var idSancionado = button.data('id_sancionado'); 
                $.ajax({
                    url: '{{ route("impugnar.load", ":id") }}'.replace(':id', {{ $item['id_sancionado'] }}),
                    type: 'GET',
                    success: function(response) {
                     // console.log(response);
                        if (Object.keys(response).length > 0) {
                            $('input[name="id_impugnacion"]').val(response.id_inpugnacion);
                            $('input[name="tipoInpugnacion"]').val(response.tipo).prop('disabled', true);
                            $('input[name="fechaResolucion"]').val(response.fecha_resolucion).prop('disabled', true);
                            $('input[name="numeroExpediente"]').val(response.numero_expediente).prop('disabled', true);
                        }else{
                            $('input[name="id_impugnacion"]').val('');
                            $('input[name="tipoInpugnacion"]').val('').prop('disabled', false);
                            $('input[name="fechaResolucion"]').val('').prop('disabled', false);
                            $('input[name="numeroExpediente"]').val('').prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
            
                        console.error(error);
                    }
                });
            });
        @endforeach
    });


</script>
@endsection

