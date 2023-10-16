@extends('layouts.app')

@section('title', 'Ventas')

@push('styles')
    <style type="text/css">

    </style>
@endpush

@section('content')

    @if (session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    @if (session('error'))
        <x-alert type="danger" message="{{ session('error') }}" />
    @endif

    <div class="card">
        <x-form class="card-body" id="form-venta" action="{{ route('venta.store') }}" method="POST" role="form">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <x-select id="ven_serie" name="ven_serie" label="Tipo de Comprobante"
                        placeholder="Seleccione un comprobante">
                        <x-slot name="options">
                            <option value="NV">Nota de Venta</option>
                            <option value="BOL">Boleta</option>
                            <option value="FAC">Factura</option>
                        </x-slot>
                    </x-select>
                </div>
                <input type="hidden" name="ven_numero" id="ven_numero">
                <div class="col-sm-12 col-md-2 col-lg-2">
                    <x-input id="documento" name="documento" label="Documento" icon="bi-file-earmark-text"
                        placeholder="NV001" />
                </div>
                <div class="col-10 col-md-4 col-lg-4">
                    <x-select id="select-cliente" name="cli_id" label="Cliente" placeholder="Seleccione un cliente">
                        <x-slot name="options">
                            @foreach ($clientes as $client)
                                <option value="{{ $client->cli_id }}">
                                    {{ $client->cli_numero_documento }} -
                                    {{ $client->cli_nombre_completo }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                </div>
                <div class="col-1 col-md-2 col-lg-2 mt-3">
                    <x-button-icon btn="btn-primary btn-sm" icon="bi-plus-circle" title="Nuevo Cliente"
                        id="btn-nuevo-cliente" type="button" />
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <x-select id="met_id" name="met_id" label="Metodo de Pago"
                        placeholder="Seleccione un metodo de pago">
                        <x-slot name="options">
                            @foreach ($metodos as $metodo)
                                <option value="{{ $metodo->met_id }}">
                                    {{ $metodo->met_nombre }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                </div>
                {{-- <div class="col-sm-12 col-md-4 col-lg-4">
                    <x-select id="his_id" name="his_id" label="Asociar Historia Clinica" placeholder="Historia clinica"
                        req="{{ false }}">
                        <x-slot name="options">

                        </x-slot>
                    </x-select>
                </div> --}}

                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="row">
                        <div class="card col-sm-12 col-md-12 col-lg-12 mt-2">
                            <div class="card-header">
                                <h4 class="card-title text-center">
                                    <strong>Detalle de Venta</strong>
                                </h4>
                                <hr />
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <x-input-load id="codigo" name="codigo" label="Codigo" icon="bi-upc-scan"
                                            placeholder="Codigo" req="{{ false }}" />
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-5">
                                        <x-select id="producto" name="producto" label="Producto"
                                            placeholder="Seleccione un producto">
                                            <x-slot name="options">
                                                @foreach ($productos as $producto)
                                                    <option value="{{ $producto->pro_id }}">
                                                        {{ $producto->pro_nombre }}
                                                    </option>
                                                @endforeach
                                            </x-slot>
                                        </x-select>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-3">
                                        <x-input id="marca" name="marca" label="Marca" icon="bi-tag"
                                            placeholder="Marca" readonly req="{{ false }}" />
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-3">
                                        <x-input id="stock" name="stock" label="Stock" icon="bi-box-seam"
                                            placeholder="Stock" readonly req="{{ false }}" />
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-3">
                                        <x-input id="cantidad" name="cantidad" label="Cantidad" icon="bi-123"
                                            placeholder="Cantidad" req="{{ false }}" />
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-3">
                                        <x-input id="precio" name="precio" label="Precio" icon="bi-cash"
                                            placeholder="Precio" req="{{ false }}" />
                                    </div>
                                    <div class="col-sm-12 col-md-2 col-lg-2 mt-3">
                                        <x-button-icon btn="btn-primary  btn-block" icon="bi-cart-plus"
                                            title="Agregar Producto" onclick="addProducto()" type="button" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 mt-2">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Codigo</th>
                                                        <th>Producto</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio</th>
                                                        <th>Subtotal</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row flex-column align-items-end mt-3">
                                    <div class="col-sm-12 col-md-3 col-lg-3 d-flex justify-content-around">
                                        <p class="text-start">
                                            <strong>Subtotal :</strong>
                                        </p>
                                        <p class="text-end">
                                            <strong>S/</strong>
                                            <span id="subtotal">0.00</span>
                                        </p>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 d-flex justify-content-around">
                                        <p class="text-start">
                                            <strong>Impuesto (18%) :</strong>
                                        </p>
                                        <p class="text-end">
                                            <strong>S/</strong>
                                            <span id="impuesto">0.00</span>
                                        </p>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3">
                                        <hr>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 d-flex justify-content-around">
                                        <p class="text-start h5">
                                            <strong>Total :</strong>
                                        </p>
                                        <p class="text-end">
                                            <strong>S/</strong>
                                            <span id="total">0.00</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row mt-3 justify-content-end">
                                    <div class="col-sm-12 col-md-12 col-lg-6 d-flex justify-content-end gap-2">
                                        <x-button id="btn-generar" btn="btn-success btn-block" title="Generar Venta"
                                            text="Generar Venta" icon="bi-cash-stack"  type="button" />

                                        <x-button id="btn-cancelar" btn="btn-danger btn-block" title="Cancelar Venta"
                                            text="Cancelar Venta" icon="bi-x-circle"  type="reset" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-form>
    </div>
    <x-modal id="modal-cliente" title="Nuevo Cliente" maxWidth="lg">
        <x-form class="modal-content" id="form-cliente" action="{{ route('cliente.registrar') }}" method="POST"
            role="form">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-clienteLabel">
                    Nuevo Cliente
                </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x"></i>
            </div>
            <div class="modal-body">
                <div class="row">
                    @include('tienda.clientes.form')
                </div>
            </div>
            <div class="modal-footer">
                <x-button id="btn-close-modal" btn="btn-secondary" title="Cerrar" data-bs-dismiss="modal"
                    position="left" text="Cerrar" icon="bi-x-circle" />
                <x-button id="btn-save-cliente" btn="btn-primary" title="Guardar" position="right" text="Guardar"
                    icon="bi-save" />
            </div>
        </x-form>
    </x-modal>
@endsection

@push('scripts')
    <script type="text/javascript">
        let Detalle = [];

        $(document).ready(function() {
            $('#select-cliente').select2();
            $('#his_id').select2();
            $('#producto').select2();

            $('#codigo').on('keyup', (e) => {
                $('#codigo').trigger('blur');
            });

            $('#ven_serie').on('change', (e) => {
                let value = $('#ven_serie').val();
                $.ajax({
                    url: "{{ url('venta/correlativo') }}/" + value,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            $('#documento').val(data.documento);
                            $('#ven_numero').val(data.numero);
                            if (value == 'BOL') {
                                $('#tdo_id').val(1).trigger('change');
                            } else if (value == 'FAC') {
                                $('#tdo_id').val(2).trigger('change');
                            } else {
                                $('#tdo_id').val("").trigger('change');
                            }
                        } else {
                            $('#documento').val('');
                            $('#ven_numero').val('');
                            messageAlert(data.message, '#dc3545', '#fff');
                        }
                    },
                    error: function(data) {
                        let errors = data.responseJSON.errors;
                        let message = data.responseJSON.message;

                        if (errors) {
                            $.each(errors, function(key, value) {
                                messageAlert(value, '#dc3545', '#fff');
                            });
                        } else {
                            messageAlert(message, '#dc3545', '#fff');
                        }
                    }
                });
            });

            $('#form-cliente').on('submit', (e) => {
                e.preventDefault();
                $('#form-cliente .is-invalid').removeClass('is-invalid');
                $('#form-cliente .invalid-feedback').remove();
                let form = $(this);
                let data = form.serialize();

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            $('#modal-cliente').modal('hide');
                            messageAlert(data.message, '#198754', '#fff');
                            $('#select-cliente').append('<option value="' + data.cliente
                                .cli_id + '">' + data.cliente.cli_numero_documento + ' - ' +
                                data.cliente.cli_nombres + ' ' + data.cliente
                                .cli_apellido_paterno + ' ' + data.cliente
                                .cli_apellido_materno + '</option>');
                            $('#select-cliente').val(data.cliente.cli_id).trigger('change');
                        } else {
                            messageAlert(data.message, '#dc3545', '#fff');
                        }
                    },
                    error: function(data) {
                        let errors = data.responseJSON.errors;
                        let message = data.responseJSON.message;

                        if (errors) {
                            $.each(errors, function(key, value) {
                                if (!$('#form-cliente').find('#' + key).hasClass(
                                        'is-invalid'))
                                    $('#form-cliente').find('#' + key).addClass(
                                        'is-invalid');
                                if ($('#form-cliente').find('#' + key).next('div')
                                    .hasClass('invalid-feedback'))
                                    $('#form-cliente').find('#' + key).next('div')
                                    .remove();
                                $('#form-cliente').find('#' + key).parent().append(
                                    '<div class="invalid-feedback">' + value +
                                    '</div>');
                                messageAlert(value, '#dc3545', '#fff');
                            });
                        } else {
                            messageAlert(message, '#dc3545', '#fff');
                        }
                    }
                });
            });

            $('#btn-nuevo-cliente').on('click', (e) => {
                let tco = $('#ven_serie').val();
                if (tco == "") {
                    messageAlert("Seleccione un tipo de comprobante", "#ffc107", "#000");
                    return false;
                } else {
                    $('#modal-cliente').modal('show');
                }
            });

            $('#codigo').on('blur', (e) => {
                let code = $(this).val();
                if (code == "") return false;
                $.ajax({
                    url: "{{ url('producto/buscar/codigo') }}/" + code,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            $('#cantidad').val(1);
                            $('#marca').val(data.marca.mar_nombre);
                            $('#stock').val(data.producto.pro_stock);
                            $('#precio').val(data.producto.pro_precio_venta);
                            $('#producto').val(data.producto.pro_id).trigger('change');
                        } else {
                            $('#marca').val('');
                            $('#stock').val('');
                            $('#cantidad').val('');
                            $('#precio').val('');
                            messageAlert(data.message, '#dc3545', '#fff');
                        }
                    },
                    error: function(data) {
                        let errors = data.responseJSON.errors;
                        let message = data.responseJSON.message;

                        if (errors) {
                            $.each(errors, function(key, value) {
                                messageAlert(value, '#dc3545', '#fff');
                            });
                        } else {
                            messageAlert(message, '#dc3545', '#fff');
                        }
                    }
                });
            });

            $('#producto').on('change', (e) => {
                console.log('change');
                let id = $('#producto').val();
                if (id == "") {
                    $('#marca').val('');
                    $('#stock').val('');
                    $('#cantidad').val('');
                    $('#precio').val('');
                    return false;
                }
                $.ajax({
                    url: "{{ url('producto/buscar/id') }}/" + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            $('#codigo').val(data.producto.pro_codigo_barra);
                            $('#marca').val(data.marca.mar_nombre);
                            $('#stock').val(data.producto.pro_stock);
                            $('#precio').val(data.producto.pro_precio_venta);
                            if ($('#cantidad').val() == 1) {
                                Detalle.push(parseDetalle(data.producto, 1));
                                addProducto();
                            } else {
                                $('#cantidad').focus();
                            }

                        } else {
                            $('#marca').val('');
                            $('#stock').val('');
                            $('#cantidad').val('');
                            $('#precio').val('');
                            messageAlert(data.message, '#dc3545', '#fff');
                        }
                    },
                    error: function(data) {
                        let errors = data.responseJSON.errors;
                        let message = data.responseJSON.message;

                        if (errors) {
                            $.each(errors, function(key, value) {
                                messageAlert(value, '#dc3545', '#fff');
                            });
                        } else {
                            messageAlert(message, '#dc3545', '#fff');
                        }
                    }
                });
            });

            $('#btn-generar').on('click', (e) => {
                (validarCampos()) ? $('#form-venta').submit(): false;
            });
        });

        function validarCampos() {
            $('#form-venta .is-invalid').removeClass('is-invalid');
            $('#form-venta .invalid-feedback').remove();
            let tco = $('#ven_serie').val();
            let cli = $('#select-cliente').val();
            let met = $('#met_id').val();
            let his = $('#his_id').val();
            let doc = $('#documento').val();
            let num = $('#ven_numero').val();

            if (tco == "") {
                messageAlert("Seleccione un tipo de comprobante", "#ffc107", "#000");
                inputError('#ven_serie', 'Seleccione un tipo de comprobante');
                inputError('#documento', 'Documento es requerido');
                $('#ven_serie').focus();
                return false;
            } else if (cli == "") {
                messageAlert("Seleccione un cliente", "#ffc107", "#000");
                inputError('#select-cliente', 'Seleccione un cliente');
                $('#select-cliente').focus();
                return false;
            } else if (met == "") {
                messageAlert("Seleccione un metodo de pago", "#ffc107", "#000");
                inputError('#met_id', 'Seleccione un metodo de pago');
                $('#met_id').focus();
                return false;
            }
            return true;
        }

        function inputError(id, message) {
            $(id).addClass('is-invalid');
            $(id).parent().append('<div class="invalid-feedback">' + message + '</div>');
        }

        function messageAlert(message, background, color) {
            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "center",
                style: {
                    background: background,
                    color: color,
                }
            }).showToast()
        }

        function parseDetalle(producto, cantidad) {
            return {
                pro_id: producto.pro_id,
                pro_codigo_barra: producto.pro_codigo_barra,
                pro_nombre: producto.pro_nombre,
                pro_precio_venta: producto.pro_precio_venta,
                pro_stock: producto.pro_stock,
                cantidad: cantidad,
                subtotal: producto.pro_precio_venta * cantidad,
                impuesto: (producto.pro_precio_venta * cantidad) * 0.18,
                total: (producto.pro_precio_venta * cantidad) + ((producto.pro_precio_venta * cantidad) * 0.18)
            }
        }

        function deleteProducto(codigo) {
            let subtotal = parseFloat($('#fila-' + codigo).find('td:eq(4)').text());
            let impuesto = subtotal * 0.18;
            let total = subtotal + impuesto;

            $('#subtotal').text((parseFloat($('#subtotal').text()) - subtotal).toFixed(2));
            $('#impuesto').text((parseFloat($('#impuesto').text()) - impuesto).toFixed(2));
            $('#total').text((parseFloat($('#total').text()) - total).toFixed(2));
            $('#fila-' + codigo).remove();
        }

        function clearDetalles() {
            $('#codigo').val('');
            $('#marca').val('');
            $('#stock').val('');
            $('#cantidad').val('');
            $('#precio').val('');
            $('#producto').val('').trigger('change');
        }

        function addProducto() {
            let codigo = $('#codigo').val();
            let producto = $('#producto option:selected').text();
            let marca = $('#marca').val();
            let stock = $('#stock').val();
            let cantidad = $('#cantidad').val();
            let precio = $('#precio').val();

            if (codigo == "") {
                messageAlert("Ingrese un codigo", "#ffc107", "#000");
                return false;
            } else if (producto == "") {
                messageAlert("Seleccione un producto", "#ffc107", "#000");
                return false;
            } else if (marca == "") {
                messageAlert("Seleccione un producto", "#ffc107", "#000");
                return false;
            } else if (stock == "") {
                messageAlert("Seleccione un producto", "#ffc107", "#000");
                return false;
            } else if (cantidad == "") {
                messageAlert("Ingrese una cantidad", "#ffc107", "#000");
                return false;
            } else if (precio == "") {
                messageAlert("Ingrese un precio", "#ffc107", "#000");
                return false;

            } else if (parseFloat(cantidad) > parseFloat(stock)) {
                messageAlert("No hay suficiente stock", "#ffc107", "#000");
                clearDetalles();
                $('#codigo').focus();
                return false;
            } else {

                let subtotal = parseFloat(cantidad) * parseFloat(precio);
                let impuesto = subtotal * 0.18;
                let total = subtotal + impuesto;
                if ($('#fila-' + codigo).length) {
                    let can = parseFloat($('#fila-' + codigo).find('td:eq(2)').text());
                    let sub = parseFloat($('#fila-' + codigo).find('td:eq(4)').text());
                    $('#fila-' + codigo).find('td:eq(2)').text((can + parseFloat(cantidad)).toFixed(0));
                    $('#fila-' + codigo).find('td:eq(3)').find('input').val(parseFloat(precio).toFixed(2));
                    $('#fila-' + codigo).find('td:eq(4)').text((sub + subtotal).toFixed(2));
                } else {
                    let fila = `<tr id="fila-${codigo}">
                                    <input type="hidden" name="codigos[]" value="${codigo}">
                                    <td>${codigo}</td>
                                    <td>${producto}</td>
                                    <input type="hidden" name="cantidades[]" value="${cantidad}">
                                    <td>${cantidad}</td>
                                    <input type="hidden" name="precios[]" value="${precio}">
                                    <td>
                                        <input type="number" class="form-control form-control-sm" value="${precio}">
                                    </td>
                                    <td>${subtotal.toFixed(2)}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteProducto('${codigo}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>`;
                    $('tbody').append(fila);
                }
                $('#subtotal').text((parseFloat($('#subtotal').text()) + subtotal).toFixed(2));
                $('#impuesto').text((parseFloat($('#impuesto').text()) + impuesto).toFixed(2));
                $('#total').text((parseFloat($('#total').text()) + total).toFixed(2));
                clearDetalles();
                $('#codigo').focus();
            }
        }
    </script>
@endpush
