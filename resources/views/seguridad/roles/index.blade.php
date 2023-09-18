@extends('layouts.app')

@section('title', 'Roles')

@push('styles')
@endpush

@section('content')

    {{-- NOTE: Mensaje de exito al realizar una accion --}}
    @if (session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <div class="card">
        <div class="card-header">
            <div class="row justify-content-end">
                <div class="col-md-3 d-flex justify-content-end">
                    <x-link-text-icon id="btn-create" btn="btn-primary" icon="bi-plus-circle" text="Nuevo Rol" position="right"
                        href="{{ route('rol.create') }}" />
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <x-table id="table-roles">
                    <x-slot name="header">
                        <th colspan="1" class="text-center">ID</th>
                        <th colspan="1" class="text-center">Rol</th>
                        <th colspan="1" class="text-center">Descripcion</th>
                        <th colspan="1" class="text-center">Acciones</th>
                    </x-slot>
                    <x-slot name='slot'>
                        @foreach ($roles as $rol)
                            <tr>
                                <td class="text-center">
                                    {{ $rol->id }}
                                </td>
                                <td class="text-center">
                                    {{ $rol->name }}
                                </td>
                                <td class="text-center">
                                    {{ $rol->description }}
                                </td>
                                <td class="text-center">
                                    <x-link-icon btn="btn-info" icon="bi-eye-fill" title="Ver"
                                        href="{{ route('rol.show', $rol) }}" />
                                    <x-link-icon btn="btn-warning" icon="bi-pencil-square" title="Editar"
                                        href="{{ route('rol.edit', $rol) }}" />
                                    <x-form-table id="form-delete-{{ $rol->id }}"
                                        action="{{ route('rol.destroy', $rol) }}" method="POST">

                                        @method('DELETE')
                                        <x-button-icon btn="btn-danger" icon="bi-trash-fill" title="Eliminar"
                                            onclick="Eliminar({{ $rol->id }})" />
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
            $.post({
                url: '{{ route('rol.verificarEliminar') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: '¿Estas seguro?',
                            text: "¡No podras revertir esto!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        })
                    } else {
                        Swal.fire({
                            title: '¡Atención!',
                            text: response.message,
                            icon: response.status,
                            timer: 4000,
                        })
                    }
                }
            })
        }
    </script>
@endpush
