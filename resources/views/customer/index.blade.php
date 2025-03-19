@extends('layouts.app')

@section('title', 'Mantenimiento de Clientes')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Listado de Clientes</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Mantenimiento</a></li>
                            <li class="breadcrumb-item active">Clientes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">Nuevo Cliente</a>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table id="customersTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Logo</th>
                                        <th>RUC</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Teléfono</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td>{{ $customer->id }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $customer->photo) }}" class="img-thumbnail" width="35" alt="Foto de {{ $customer->name }}">
                                            </td>
                                            <td>{{ $customer->ruc }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->status }}</td>
                                            <td>
                                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                                <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $customer->id }}">Eliminar</button>
                                                <form id="delete-form-{{ $customer->id }}" action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br/>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#customersTable').DataTable({
            language: {
               "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
            },
            responsive: true,
            autoWidth: false,
            lengthMenu: [10, 25, 50, 75, 100],
            pageLength: 10,
            order: [[0, 'desc']],
            // Habilitar botones
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'colvis',
                    text: 'Seleccionar Columnas',
                    className: 'btn btn-primary',
                    postfixButtons: ['colvisRestore']
                }
            ]
        });

        // Personalizar los estilos al cambiar visibilidad de columnas
        table.on('buttons-action', function (e, buttonApi, dataTable, node, config) {
            setTimeout(function () {
                $('.dt-button-collection .dt-button').each(function () {
                    var buttonText = $(this).text();
                    var isActive = $(this).hasClass('active');

                    if (isActive) {
                        $(this).css({
                            "background-color": "#28a745", // Verde si está activo
                            "color": "white",
                            "font-weight": "bold"
                        });
                    } else {
                        $(this).css({
                            "background-color": "#dc3545", // Rojo si está desactivado
                            "color": "white",
                            "font-weight": "bold"
                        });
                    }
                });
            }, 10);
        });

        // SweetAlert2 para eliminar cliente
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            let customerId = $(this).data('id');
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'No podrás revertir esta acción.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + customerId).submit();
                }
            });
        });
    });
</script>
@endpush
