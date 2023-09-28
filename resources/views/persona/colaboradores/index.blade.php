@extends('layouts.app')

@section('title', 'Colaboradores')

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
                    <x-link-text-icon id="btn-create" btn="btn-primary" icon="bi-plus-circle" text="Nuevo Colaborador"
                        position="right" href="{{ route('colaborador.create') }}" />
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <x-table id="table-colaboradores">
                    <x-slot name="header">
                        <th colspan="1" class="text-center">ID</th>
                        <th colspan="1" class="text-center">Documento</th>
                        <th colspan="1" class="text-center">Nombre</th>
                        <th colspan="1" class="text-center">Apellido</th>
                        <th colspan="1" class="text-center">Acciones</th>
                    </x-slot>
                    <x-slot name='slot'>
                        @foreach ($colaboradores as $colaborador)
                            <tr>
                                <td class="text-center">
                                    {{ $colaborador->col_id }}
                                </td>
                                <td class="text-center">
                                    {{ $colaborador->col_numero_documento }}
                                </td>
                                <td class="text-center">
                                    {{ $colaborador->col_nombres }}
                                </td>
                                <td class="text-center">
                                    {{ $colaborador->col_apellido_paterno }} {{ $colaborador->col_apellido_materno }}
                                </td>
                                <td class="text-center">
                                    <x-link-icon btn="btn-info" icon="bi-eye-fill" title="Ver"
                                        href="{{ route('colaborador.show', $colaborador) }}" />
                                    <x-link-icon btn="btn-warning" icon="bi-pencil-square" title="Editar"
                                        href="{{ route('colaborador.edit', $colaborador->col_id) }}" />
                                    <x-form-table id="form-delete-{{ $colaborador }}" method="POST"
                                        action="{{ route('colaborador.destroy', $colaborador) }}" role="form">
                                        @method('DELETE')
                                        <x-button-icon btn="btn-danger" icon="bi-trash-fill" title="Eliminar"
                                            onclick="Eliminar({{ $colaborador->col_id }})" />
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
            const form = $('#form-delete-' + id);
            $.post({
                url: '{{ route('colaborador.verificarEliminar') }}',
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
