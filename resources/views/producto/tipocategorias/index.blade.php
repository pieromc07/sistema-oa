@extends('layouts.app')

@section('title', 'tipo de categoría')
@section('title-page', 'Tipos de Categoría')

@push('styles')
@endpush

@section('content')

    {{-- NOTE: Mensaje de exito al realizar una accion --}}
    @if (session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif
    <div class="row justify-content-center flex-grow-1">
        <div class="col-xs-12 col-md-12 col-lg-5">
            @if ($tipoCategoria->tic_id != null)
                @include('producto.tipocategorias.edit')
            @else
                @include('producto.tipocategorias.create')
            @endif
        </div>
        <div class="col-xs-12 col-md-12 col-lg-7">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <x-table id="table-tipoCategorias">
                            <x-slot name="header">
                                <th colspan="1" class="text-center">ID</th>
                                <th colspan="1" class="text-center">Tipo de Categoria</th>
                                <th colspan="1" class="text-center">Acciones</th>
                            </x-slot>
                            <x-slot name='slot'>
                                @foreach ($tipoCategorias as $tipoCategoria)
                                    <tr>
                                        <td class="text-center">
                                            {{ $tipoCategoria->tic_id }}
                                        </td>
                                        <td class="text-center">
                                            {{ $tipoCategoria->tic_nombre }}
                                        </td>
                                        <td class="text-center">
                                            <x-button-icon btn="btn-info" icon="bi-eye-fill" title="Ver"
                                                onclick="Ver({{ $tipoCategoria }})" />
                                            <x-form-table id="form-edit-{{ $tipoCategoria->tic_id }}"
                                                action="{{ route('tipocategoria.index') }}" method="GET" role="search">
                                                <input type="hidden" name="search" value="{{ $tipoCategoria->tic_id }}">
                                                <x-button-icon btn="btn-warning" icon="bi-pencil-square" title="Editar" />
                                            </x-form-table>

                                            <x-form-table id="form-delete-{{ $tipoCategoria->tic_id }}"
                                                action="{{ route('tipocategoria.destroy', $tipoCategoria) }}" method="POST"
                                                role="form">
                                                @method('DELETE')
                                                <x-button-icon btn="btn-danger" icon="bi-trash-fill" title="Eliminar"
                                                    onclick="Eliminar({{ $tipoCategoria->tic_id }})" />
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
    @include('producto.tipocategorias.show')
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(() => {});

        function Ver(tic) {
            $('#modal-showLabel').html('Ver Tipo de Categoria');
            $('#tic_nombre-show').val(tic.tic_nombre);
            $('#modal-show').modal('show');
        }

        function Eliminar(id) {
            event.preventDefault();
            const form = $('#form-delete-' + id);
            $.post({
                url: '{{ route('tipocategoria.verificarEliminar') }}',
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
