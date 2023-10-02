@extends('layouts.app')

@section('title', 'categoría')
@section('title-page', 'Categorías')

@push('styles')
@endpush

@section('content')

    {{-- NOTE: Mensaje de exito al realizar una accion --}}
    @if (session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif
    <div class="row justify-content-center flex-grow-1">
        <div class="col-xs-12 col-md-12 col-lg-5">
            @if ($categoria->cat_id != null)
                @include('producto.categorias.edit')
            @else
                @include('producto.categorias.create')
            @endif
        </div>
        <div class="col-xs-12 col-md-12 col-lg-7">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <x-table id="table-categorias">
                            <x-slot name="header">
                                <th colspan="1" class="text-center">ID</th>
                                <th colspan="1" class="text-center">Categoría</th>
                                <th colspan="1" class="text-center">Tipo Categoría</th>
                                <th colspan="1" class="text-center">Acciones</th>
                            </x-slot>
                            <x-slot name='slot'>
                                @foreach ($categorias as $categoria)
                                    <tr>
                                        <td class="text-center">
                                            {{ $categoria->cat_id }}
                                        </td>
                                        <td class="text-center">
                                            {{ $categoria->cat_nombre }}
                                        </td>
                                        <td class="text-center">
                                            {{ $categoria->tipo_categorias->tic_nombre }}
                                        </td>
                                        <td class="text-center">
                                            <x-button-icon btn="btn-info" icon="bi-eye-fill" title="Ver"
                                                onclick="Ver({{ $categoria }})" />
                                            <x-form-table id="form-edit-{{ $categoria->cat_id }}"
                                                action="{{ route('categoria.index') }}" method="GET" role="search">
                                                <input type="hidden" name="search" value="{{ $categoria->cat_id }}">
                                                <x-button-icon btn="btn-warning" icon="bi-pencil-square" title="Editar" />
                                            </x-form-table>

                                            <x-form-table id="form-delete-{{ $categoria->cat_id }}"
                                                action="{{ route('categoria.destroy', $categoria) }}" method="POST" role="form">
                                                @method('DELETE')
                                                <x-button-icon btn="btn-danger" icon="bi-trash-fill" title="Eliminar"
                                                    onclick="Eliminar({{ $categoria->cat_id }})" />
                                            </x-form-table>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('producto.categorias.show')
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(() => {});

        function Ver(cat) {
            $('#modal-showLabel').html('Ver Categoría');
            $('#cat_nombre-show').val(cat.cat_nombre);
            $('#tic_nombre-show').val(cat.tipo_categorias.tic_nombre);
            $('#modal-show').modal('show');
        }

        function Eliminar(id) {
            event.preventDefault();
            const form = $('#form-delete-' + id);
            $.post({
                url: '{{ route('categoria.verificarEliminar') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: "¡No podrás revertir esto!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: '¡Atención!',
                            text: response.message,
                            icon: response.status,
                            timer: 4000,
                        });
                    }
                },
            });
        }
    </script>
@endpush
