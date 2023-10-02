@extends('layouts.app')

@section('title', 'Productos')


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
        <div class="card-header">
            <div class="row justify-content-end">
                <div class="col-md-3 d-flex justify-content-end">
                    <x-link-text-icon id="btn-create" btn="btn-primary" icon="bi-plus-circle" text="Nuevo Producto"
                        position="right" href="{{ route('producto.create') }}" />
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <x-table id="table-productos">
                    <x-slot name="header">
                        <th colspan="1" class="text-center">ID</th>
                        <th colspan="1" class="text-center">Nombre</th>
                        <th colspan="1" class="text-center">Stock</th>
                        <th colspan="1" class="text-center">Código de barra</th>
                        <th colspan="1" class="text-center">P. Venta</th>
                        <th colspan="1" class="text-center">Categoría</th>
                        <th colspan="1" class="text-center">Marca</th>
                        <th colspan="1" class="text-center">Acciones</th>
                    </x-slot>
                    <x-slot name='slot'>
                        @foreach ($productos as $producto)
                            <tr>
                                <td class="text-center">
                                    {{ $producto->pro_id }}
                                </td>
                                <td class="text-center">
                                    {{ $producto->pro_nombre }}
                                </td>
                                <td class="text-center">
                                    {{ $producto->pro_stock }}
                                </td>
                                <td class="text-center">
                                    {{ $producto->pro_codigo_barra }}
                                </td>
                                <td class="text-center">
                                    {{ $producto->pro_precio_venta }}
                                </td>
                                <td class="text-center">
                                    {{ $producto->categoria->cat_nombre }}
                                </td>
                                <td class="text-center">
                                    {{ $producto->marca->mar_nombre }}
                                </td>
                                <td class="text-center d-flex justify-content-center gap-1">
                                    <x-link-icon btn="btn-info" icon="bi-eye-fill" title="Ver"
                                        href="{{ route('producto.show', $producto) }}" />
                                    <x-link-icon btn="btn-warning" icon="bi-pencil-square" title="Editar"
                                        href="{{ route('producto.edit', $producto->pro_id) }}" />
                                    <x-form-table id="form-delete-{{ $producto->pro_id }}" method="POST"
                                        action="{{ route('producto.destroy', $producto) }}" role="form">
                                        @method('DELETE')
                                        <x-button-icon btn="btn-danger" icon="bi-trash-fill" title="Eliminar"
                                            onclick="Eliminar({{ $producto->pro_id }})" />
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
    <script type="text/javascript">
        $(document).ready(() => {

        });

        function Eliminar(id) {
            event.preventDefault();
            const form = $(`#form-delete-${id}`);
            Swal.fire({
                title: '¿Estas seguro de eliminar el registro?',
                text: "Esta accion no se puede revertir!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Si, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        }
    </script>
@endpush
