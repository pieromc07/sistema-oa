@extends('layouts.app')

@section('title', 'Ventas')

@push('styles')
@endpush

@section('content')
    @if (session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    @if (session('error'))
        <x-alert type="danger" message="{{ session('error') }}" />
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <x-table id="table-ventas">
                    <x-slot name="header">
                        <th colspan="1" class="text-center">ID</th>
                        <th colspan="1" class="text-center">Fecha</th>
                        <th colspan="1" class="text-center">Cliente</th>
                        <th colspan="1" class="text-center">Total</th>
                        <th colspan="1" class="text-center">Acciones</th>
                    </x-slot>
                    <x-slot name='slot'>
                        @foreach ($ventas as $venta )
                            <tr>
                                <td class="text-center">
                                    {{ $venta->ven_id }}
                                </td>
                                <td class="text-center">
                                    {{ $venta->ven_fecha }}
                                </td>
                                <td class="text-center">
                                    {{ $venta->cliente->cli_nombres }} {{ $venta->cliente->cli_apellido_paterno }}
                                    {{ $venta->cliente->cli_apellido_materno }}
                                </td>
                                <td class="text-center">
                                    {{ $venta->ven_total }}
                                </td>
                                <td class="text-center">
                                    <x-link-icon btn="btn-info" icon="bi-eye-fill" title="Ver"
                                        href="{{ route('venta.show', $venta) }}" />
                                    <x-link-icon btn="btn-warning" icon="bi-pencil-square" title="Editar"
                                        href="{{ route('venta.edit', $venta->ven_id) }}" />
                                    <x-form-table id="form-delete-{{ $venta }}" method="POST"
                                        action="{{ route('venta.destroy', $venta) }}" role="form">
                                        @method('DELETE')
                                        <x-button-icon btn="btn-danger" icon="bi-trash-fill" title="Eliminar"
                                            onclick="deleteItem({{ $venta }})" />
                                    </x-form-table>
                                </td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush


