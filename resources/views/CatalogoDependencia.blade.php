
@extends('layouts.app')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Dependencias</h4>
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
                                    data-bs-target="#modalAgregarDependencia">
                                    <i class="ri-add-circle-line"></i> <span>Agregar</span>
                                </button>
                                @endif
                            </div><br>
                            <div class="tab-content">
                                <div class="tab-pane show active" >
                                    <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre de la Dependencia</th>
                                                <th>Nomenclatura</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($catalogo as $item)
                                                <tr>
                                                    <td>{{ $item['id_catalogo_dependecia'] }}</td>
                                                    <td>{{ $item['nombre_dependencia'] }}</td>
                                                    <td>{{ $item['nomenclatura'] }}</td>
                                                    <td>
                                                        @if (Auth::user()->super() or Auth::user()->administrador())
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalEditarDependencia{{ $item['id_catalogo_dependecia'] }}">
                                                            <i class="ri-file-edit-line"></i>
                                                        </button>
                                                        <form
                                                            action="{{ route('catalogo_dependencia.destroy', $item['id_catalogo_dependecia']) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-primary eliminar-button-dependencia">
                                                                <i class="ri-delete-bin-2-fill"></i>
                                                            </button>
                                                        </form>
                                                        @endif
                                                    </td>
                                                </tr>   
                                                <!--start modal editar dependencia-->
                                                <div id="modalEditarDependencia{{ $item['id_catalogo_dependecia'] }}" class="modal fade"
                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> Editar Dependencia </h4>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="POST"
                                                            action="{{ route('catalogo_dependencia.update', $item['id_catalogo_dependecia']) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class=" mb-3">
                                                                    <label>Nombre</label>
                                                                    <input type="text"
                                                                        class="form-control form-control"
                                                                        name="nombreDependenciaEdit"
                                                                        placeholder="{{ $item['nombre_dependencia'] }}" />
                                                                </div>
                                                                <div class=" mb-3">
                                                                    <label>Nomenclatura</label>
                                                                    <input type="text"
                                                                        class="form-control form-control"
                                                                        name="nomenclaturaDependenciaEdit"
                                                                        placeholder="{{ $item['nomenclatura'] }}" />
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
                                            <!-- end modal editar dependencia-->   
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- start Modal de agregar  dependencia-->
                            <div id="modalAgregarDependencia" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"> Agregar Dependencia </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('catalogo_dependencia.store') }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class=" mb-3">
                                                    <label>Nombre</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="nombreDependencia" />
                                                </div>
                                                <div class=" mb-3">
                                                    <label>Nomenclatura</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="nomenclaturaDependencia" />
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
                            <!-- end Modal de agregar  dependencia -->  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const eliminarButtons = document.querySelectorAll('.eliminar-button-dependencia');

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


