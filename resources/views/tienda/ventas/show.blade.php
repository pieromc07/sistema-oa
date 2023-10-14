@extends('layouts.app')

@section('title', 'Venta')

@push('styles')
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-6 col-sm-6 col-md-2 col-lg-2">
                    <x-input type="text" id="ven_fecha" placeholder="Fecha" icon="bi-calendar3" name="ven_fecha"
                        value="{{ $venta->ven_fecha }}" label="Fecha" req="{{ false }}" />
                </div>
                <div class="col-6 col-sm-6 col-md-2 col-lg-2">
                    <x-input type="text" id="ven_serie" placeholder="Serie" icon="bi-file-earmark-text" name="ven_serie"
                        value="{{ $venta->ven_serie }} - {{ $venta->ven_numero }}" label="Serie"
                        req="{{ false }}" />
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                    <x-input type="text" id="cli_numero_documento " placeholder="N° Documento"
                        icon="bi-file-earmark-text" name="cli_numero_documento"
                        value="{{ $venta->cliente->cli_numero_documento }}" label="N° Documento"
                        req="{{ false }}" />
                </div>
                <div class="col-12 col-sm-12 col-md-5 col-lg-5">
                    <x-input type="text" id="cli_nombres" placeholder="Cliente" icon="bi-person-fill" name="cli_nombres"
                        value="{{ $venta->cliente->cli_nombres }} {{ $venta->cliente->cli_apellido_paterno }} {{ $venta->cliente->cli_apellido_materno }}"
                        label="Cliente" req="{{ false }}" />
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                    <x-input type="text" id="met_nombre" placeholder="Metodo de Pago" icon="bi-cash" name="met_nombre"
                        value="{{ $venta->metodo_pago->met_nombre }}" label="Metodo de Pago" req="{{ false }}" />
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                    <x-input type="text" id="ven_total" placeholder="Total" icon="bi-cash" name="ven_total"
                        value="{{ $venta->ven_total }}" label="Total" req="{{ false }}" />
                </div>
                {{-- <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                    <x-input type="text" id="ven_subtotal" placeholder="Subtotal" icon="bi-cash" name="ven_subtotal"
                        value="{{ $venta->ven_subtotal }}" label="Subtotal" req="{{ false }}" />
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                    <x-input type="text" id="ven_igv" placeholder="IGV" icon="bi-cash" name="ven_igv"
                        value="{{ $venta->ven_impuesto }}" label="IGV" req="{{ false }}" />
                </div> --}}
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detalles as $detalle)
                                    <tr class="text-center">
                                        <td class="text-center">
                                            {{ $detalle->producto->pro_codigo_barra }}
                                        </td>
                                        <td class="text-center">
                                            {{ $detalle->producto->pro_nombre }}
                                        </td>
                                        <td class="text-center">
                                            {{ $detalle->vde_cantidad }}
                                        </td>
                                        <td class="text-center">
                                            {{ $detalle->vde_precio }}
                                        </td>
                                        <td class="text-center">
                                            {{ $detalle->vde_subtotal }}
                                        </td>
                                    </tr>
                                @endforeach
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
                        <span id="subtotal">
                            {{ $venta->ven_subtotal }}
                        </span>
                    </p>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3 d-flex justify-content-around">
                    <p class="text-start">
                        <strong>Impuesto (18%) :</strong>
                    </p>
                    <p class="text-end">
                        <strong>S/</strong>
                        <span id="impuesto">
                            {{ $venta->ven_impuesto }}
                        </span>
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
                        <span id="total">
                            {{ $venta->ven_total }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="row my-4 align-items-center justify-content-end">
                <div class="col-12 col-md-4 col-lg-4 d-flex justify-content-end">
                    <x-link-text-icon href="{{ route('venta.index') }}" btn="btn-primary btn-block" icon="bi-arrow-left-circle"
                        text="Volver" />
                </div>
            </div>

        </div>
    </div>
@endsection
