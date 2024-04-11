

@extends('layouts.app')

@section('content')

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Sanciones Impuestas</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="right">
                                @if (Auth::user()->super() or Auth::user()->administrador())
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modalAgregarSanciones">
                                    <i class="ri-add-circle-line"></i> <span>Agregar</span>
                                </button>
                                @endif
                            </div><br>
                            <div class="tab-content">
                                <div class="tab-pane show active">
                                    <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre De La Sanción</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($catalogo as $item)
                                                <tr>
                                                    <td>{{ $item['id_catalogo_sanciones'] }}</td>
                                                    <td>{{ $item['nombre_sancion'] }}</td>
                                                    <td>
                                                        @if (Auth::user()->super() or Auth::user()->administrador())
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalEditarSancion{{ $item['id_catalogo_sanciones'] }}">
                                                            <i class="ri-file-edit-line"></i>
                                                        </button>
                                                        <form
                                                            action="{{ route('catalogo_sanciones.destroy', $item['id_catalogo_sanciones']) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-primary eliminar-button-sancion">
                                                                <i class="ri-delete-bin-2-fill"></i>
                                                            </button>
                                                        </form>
                                                        @endif
                                                    </td>
                                                </tr>   
                                                <!--start modal editar sanciones-->
                                                <div id="modalEditarSancion{{ $item['id_catalogo_sanciones'] }}" class="modal fade"
                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> Editar Sancion </h4>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="POST"
                                                            action="{{ route('catalogo_sanciones.update', $item['id_catalogo_sanciones']) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class=" mb-3">
                                                                    <label>Nombre</label>
                                                                    <input type="text"
                                                                        class="form-control form-control"
                                                                        name="nombreSancionEdit"
                                                                        placeholder="{{ $item['nombre_sancion'] }}" />
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cerrar</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Guardar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end modal editar sanciones-->   
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- start Modal de agregar  sanciones-->
                            <div id="modalAgregarSanciones" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"> Agregar Sancion </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('catalogo_sanciones.store') }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class=" mb-3">
                                                    <label>Nombre</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="nombreSancion" />
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Agregar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end Modal de agregar  sanciones -->  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const eliminarButtons = document.querySelectorAll('.eliminar-button-sancion');

    eliminarButtons.forEach(function (eliminarButton) {
        eliminarButton.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción eliminará el registro. ¿Deseas continuar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminarButton.parentElement.submit();
                }
            });
        });
    });
});

    document.addEventListener('DOMContentLoaded', function () {
        const status = {{ session('status') ?? 0 }};

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

</script>
@endsection

