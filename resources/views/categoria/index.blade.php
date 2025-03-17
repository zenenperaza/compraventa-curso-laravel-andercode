@extends('layouts.app')

@section('title', 'Mantenimiento de Categoria')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Listado de Categorias</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Mantenimiento</a></li>
                                <li class="breadcrumb-item active">Categoria</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <a href="{{ route('categorias.create') }}" class="btn btn-primary mb-3">Nueva Categoría</a>

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <div class="table-responsive">
                                <table id="categoriasTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categorias as $categoria)
                                            <tr>
                                                <td>{{ $categoria->id }}</td>
                                                <td>{{ $categoria->name }}</td>
                                                <td>{{ $categoria->description }}</td>
                                                <td>
                                                    <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                                    <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $categoria->id }}">Eliminar</button>
                                                    <form id="delete-form-{{ $categoria->id }}" action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" class="d-none">
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
        var table = $('#categoriasTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
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

        // SweetAlert2 para eliminar categoría
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            let categoryId = $(this).data('id');
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
                    document.getElementById('delete-form-' + categoryId).submit();
                }
            });
        });
    });
</script>

@endpush

