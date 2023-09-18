@extends('layouts.app')

@section('title', 'Usuarios')

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
                    <x-link-text-icon id="btn-create" btn="btn-primary" icon="bi-plus-circle" text="Nuevo Usuario"
                        position="right" href="{{ route('usuario.create') }}" />
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <x-table id="table-usuarios">
                    <x-slot name="header">
                        <th colspan="1" class="text-center">ID</th>
                        <th colspan="1" class="text-center">Nombre</th>
                        <th colspan="1" class="text-center">Estado</th>
                        <th colspan="1" class="text-center">Colaborador</th>
                        <th colspan="1" class="text-center">Acciones</th>
                    </x-slot>
                    <x-slot name='slot'>
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <td class="text-center">
                                    {{ $usuario->usu_id }}
                                </td>
                                <td class="text-center">
                                    {{ $usuario->usu_nombre }}
                                </td>
                                <td class="text-center">
                                    @if ($usuario->usu_estado == 1)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $usuario->colaborador->col_nombres }}
                                    {{ $usuario->colaborador->col_apellido_paterno }}
                                    {{ $usuario->colaborador->col_apellido_materno }}
                                </td>
                                <td class="text-center">
                                    <x-link-icon btn="btn-info" icon="bi-eye-fill" title="Ver"
                                        href="{{ route('usuario.show', $usuario) }}" />
                                    <x-link-icon btn="btn-warning" icon="bi-pencil-square" title="Editar"
                                        href="{{ route('usuario.edit', $usuario) }}" />
                                    <x-form-table id="form-delete-{{ $usuario->usu_id }}" action="{{ route('usuario.destroy', $usuario) }}" method="POST" role="form">
                                        @csrf
                                        @method('DELETE')
                                        <x-button-icon btn="btn-danger" icon="bi-trash-fill" title="Eliminar" onclick="Eliminar({{ $usuario->usu_id }})" />
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



    </script>
@endpush
