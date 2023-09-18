@extends('layouts.app')

@section('title', 'permisos')
@section('title-page', 'Permisos')

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
                    <x-link-text-icon id="btn-create" btn="btn-primary" icon="bi-plus-circle" text="Nuevo Permiso"
                        position="right" href="{{ route('permiso.create') }}" />
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <x-table id="table-permisos">
                    <x-slot name="header">
                        <th colspan="1" class="text-center">ID</th>
                        <th colspan="1" class="text-center">Nombre</th>
                        <th colspan="1" class="text-center">Permiso</th>
                        <th colspan="1" class="text-center">guard</th>
                        <th colspan="1" class="text-center">Acciones</th>
                    </x-slot>
                    <x-slot name='slot'>
                        @foreach ($permisos as $permiso)
                            <tr>
                                <td class="text-center">
                                    {{ $permiso->id }}
                                </td>
                                <td class="text-center">
                                    {{ $permiso->description }}
                                </td>
                                <td class="text-center">
                                    {{ $permiso->name }}
                                </td>
                                <td class="text-center">
                                    {{ $permiso->guard_name }}
                                </td>
                                <td class="text-center">
                                    <x-button-icon btn="btn-info" icon="bi-eye-fill" title="Ver"
                                        onclick="Ver({{ $permiso }})" />
                                    <x-link-icon btn="btn-warning" icon="bi-pencil-square" title="Editar"
                                        href="{{ route('permiso.edit', $permiso) }}" />

                                    <x-form-table id="form-delete-{{ $permiso->id }}"
                                        action="{{ route('permiso.destroy', $permiso) }}" method="POST" role="form">
                                        @method('DELETE')
                                        <x-button-icon btn="btn-danger" icon="bi-trash-fill" title="Eliminar"
                                            onclick="Eliminar({{$permiso->id}})" />
                                    </x-form-table>
                                </td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-table>
            </div>
        </div>
    </div>
    @include('seguridad.permisos.show')
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(() => {

        });

        function Ver(per) {
            $('#modal-showLabel').html('Ver Permiso');
            $('#name').val(per.name);
            $('#description').val(per.description);
            $('#guard_name').val(per.guard_name);
            $('#modal-show').modal('show');
        }

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
