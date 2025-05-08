@extends('layouts.app')

@section('title', 'Listado de Compras')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Compras Registradas</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Mantenimiento</a></li>
                            <li class="breadcrumb-item active">Compras</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('compras.create') }}" class="btn btn-primary mb-3">Nueva Compra</a>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table id="comprasTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Proveedor</th>
                                        <th>Tipo Documento</th>
                                        <th>Usuario</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($compras as $compra)
                                        <tr>
                                            <td>{{ $compra->id }}</td>
                                            <td>{{ $compra->supplier->name }}</td>
                                            <td>{{ $compra->tipodocumento->name }}</td>
                                            <td>{{ $compra->user->name }}</td>
                                            <td>{{ $compra->purchase_date }}</td>
                                            <td>$. {{ number_format($compra->total_cost, 2) }}</td>
                                            <td>{{ ucfirst($compra->status) }}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm view-details" data-id="{{ $compra->id }}">Detalles</button>
                                                <a href="{{ route('compras.pdf', $compra->id) }}" class="btn btn-danger btn-sm" target="_blank">PDF</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Detalles de Compra -->
<div class="modal fade" id="detalleCompraModal" tabindex="-1" aria-labelledby="detalleCompraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detalleCompraModalLabel">Detalles de la Compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Costo Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="detalleCompraBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#comprasTable').DataTable({
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

        $('.view-details').on('click', function() {
            let compraId = $(this).data('id');
            $.ajax({
                url: `compras/detalle/${compraId}`,
                method: 'GET',
                success: function(response) {
                    let detalleBody = $('#detalleCompraBody');
                    detalleBody.empty();
                    response.forEach(detalle => {
                        detalleBody.append(`
                            <tr>
                                <td>${detalle.producto.name}</td>
                                <td>${detalle.quantity}</td>
                                <td>$. ${parseFloat(detalle.unit_cost).toFixed(2)}</td>
                                <td>$. ${parseFloat(detalle.subtotal).toFixed(2)}</td>
                            </tr>
                        `);
                    });
                    $('#detalleCompraModal').modal('show');
                }
            });
        });
    });
</script>
@endpush
