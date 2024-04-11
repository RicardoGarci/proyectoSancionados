@extends('layouts.app')

@section('content')
<div class="content-page">
    <div class="content" >
        <div class="container-fluid" >

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h2 class="page-title">Información General</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Fecha resolucion</label>
                        <input type="text" class="form-control date" id="fechaResolucion" data-toggle="date-picker" data-cancel-class="btn-warning" value="">
                    </div> 
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Fecha Registro</label>
                        <input type="text" class="form-control date" id="fechaRegistro" data-toggle="date-picker" data-cancel-class="btn-warning" value="">
                    </div> 
                </div>
                
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label">Autoridades Sancionadoras</label>
                        <select name="slcAutoridad" class="form-control">
                            <option value="">Seleccione una opción</option>
                            @foreach ($autoridades as $autoridad)
                                <option value="{{ $autoridad['id_catalogo_autoridades'] }}">{{ $autoridad['nombre_autoridad'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label  class="form-label">Sanciones Impuestas</label>
                        <select name="slcSancion" class="form-control">
                            <option value="">Seleccione una opción</option>
                            @foreach ($sanciones as $sancion)
                                <option value="{{ $sancion->id_catalogo_sanciones }}">{{ $sancion->nombre_sancion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label">Dependencias</label>
                        <select name="slcDependencia" class="form-control">
                            <option value="">Seleccione una opción</option>
                            @foreach ($dependencias as $dependencia)
                                <option value="{{ $dependencia->id_catalogo_dependecia }}">{{ $dependencia->nombre_dependencia }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div align="center">
                <button type="submit" id="cargarDatosBtn"  class="btn btn-primary mb-2 rounded-pill">
                    <i class="ri-search-eye-line"></i>
                    Filtrar Datos
                </button>
                <button type="submit" id="limpiarDatosBtn"  class="btn btn-success mb-2 rounded-pill">
                    <i class="mdi mdi-broom"></i>
                    Limpiar Datos
                </button>
            </div>
                                
                                                              
            <table id="scroll" class="table w-100 nowrap">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>CURP</th>
                        <th>Nº De Expediente</th>
                        <th>Fecha De Resolución</th>
                        <th>Duración</th>
                        <th>Monto</th>
                        <th>Fecha De Inicio</th>
                        <th>Fecha De Término</th>
                        <th>Fecha De Registro</th>
                        <th>Cargo Del Servidor Público Sancionado</th>
                        <th>Sanción Impuesta</th>
                        <th>Autoridad Sancionadora</th>
                        <th>Nombre Del Ente Público</th>
                        <th>Falta Por La Cual Fue Sancionado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reportInicial as $item)
                    <tr>
                        <td>{{ $item['nombre_completo'] }} {{  $item['apellidos'] }} </td>
                        <td>{{ $item['curp'] }} </td>
                        <td>{{ $item['numero_expediente'] }} </td>
                        <td>{{ $item['fecha_resolucion'] }} </td>
                        <td>{{ $item['duracion_resolucion'] }} </td>
                        @if($item['monto'])
                            <td>${{ $item['monto'] }}</td>
                        @else
                            <td>{{ $item['monto'] }}</td>
                        @endif
                        <td>{{ $item['fecha_inicio'] }} </td>
                        <td>{{ $item['fecha_termino'] }} </td>
                        <td>{{ $item['fechaRegistro'] }} </td>
                        <td>{{ $item['cargo_servidor_publico'] }} </td>
                        <td>{{ $item['nombre_sancion'] }} </td>
                        <td>{{ $item['nombre_autoridad'] }} </td>
                        <td>{{ $item['nombre_dependencia'] }} </td> 
                        <td><textarea rows="3" class="form-control">{{ $item['observaciones'] }}</textarea></td>  
                    </tr>
                      
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>


<!-- Agrega las bibliotecas para exportar a Excel y PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>


<script>


document.addEventListener('DOMContentLoaded', function() {
 
    var fechaResolucion = document.getElementById('fechaResolucion');
    var fechaRegistro = document.getElementById('fechaRegistro');
    fechaResolucion.value = '';
    fechaRegistro.value = '';
});

$(document).ready(function() {
    var table = $("#scroll").DataTable({
        dom: 'Bfrtip',
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Excel',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print', 
                text: 'Imprimir', 
                exportOptions: {
                    columns: [0,1,2,3,8,9,10] 
                },
                customize: function(win) {
                    $(win.document.body).find('table').addClass('compact').css('font-size', '8px');
                }
            }
        ]
    });

    $("#limpiarDatosBtn").on("click", function() {
    $("#fechaResolucion").val("");
    $("#fechaRegistro").val("");
    $("select[name='slcAutoridad']").val("");
    $("select[name='slcSancion']").val("");
    $("select[name='slcDependencia']").val("");

});

    // Agrega el evento click al botón de filtrar
    $("#cargarDatosBtn").on("click", function() {
        let fechaResolucion = $("#fechaResolucion").val();
        let fechaRegistro = $("#fechaRegistro").val();
        let autoridad = $("select[name='slcAutoridad']").val();
        let sancion = $("select[name='slcSancion']").val();
        let dependencia = $("select[name='slcDependencia']").val();

        $.ajax({
            url: '/obtenerDatosFiltrados',
            method: 'GET',
            data: {
                fechaResolucion: fechaResolucion,
                fechaRegistro: fechaRegistro,
                autoridad: autoridad,
                sancion: sancion,
                dependencia: dependencia
            },
            success: function(response) {
                // Borra los datos actuales de la tabla
                table.clear().draw();

               // console.log(response);
            if (response && response.length > 0) {
                response.forEach(function(item) {

                let observacionesColumn;
                if (item.observaciones !== null && item.observaciones !== undefined) {
                    observacionesColumn = `<td><textarea rows="3" class="form-control">${item.observaciones}</textarea></td>`;
                } else {
                    observacionesColumn = `<td><textarea rows="3" class="form-control"></textarea></td>`;
                }
                // Combinar nombre completo y apellidos en una columna
                let nombreCompletoColumn = `<td>${item.nombre_completo} ${item.apellidos}</td>`;
                let montoColumn;
                if (item.monto !== null && item.monto !== undefined && item.monto !== "") {
                    montoColumn = `<td>$${item.monto}</td>`;
                } else {
                    montoColumn = `<td></td>`; 
                }
                // Agregar una fila a la tabla con los datos del objeto 'item'
                table.row.add([
                    nombreCompletoColumn,
                    item.curp,
                    item.numero_expediente,
                    item.fecha_resolucion,
                    item.duracion_resolucion,
                    montoColumn,
                    item.fecha_inicio,
                    item.fecha_termino,
                    item.fechaRegistro,
                    item.cargo_servidor_publico,
                    item.nombre_sancion,
                    item.nombre_autoridad,
                    item.nombre_dependencia,
                    observacionesColumn
                    // Agregar más columnas según sea necesario
                    ]).draw(false);
                });
            }
            },
            error: function(xhr, status, error) {
                console.error(error);
        
            }
        });
    });
});

</script>
@endsection
