@extends('layouts.app')

@section('title', 'Citas')

@push('styles')
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row justify-content-end">
            <div class="col-md-3 d-flex justify-content-end">
                <x-link-text-icon id="btn-create" btn="btn-primary" icon="bi-plus-circle" text="Nueva Cita"
                    position="right" href="{{ route('cita.create') }}" />
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <x-table id="table-citas">
                <x-slot name="header">
                    <th colspan="1" class="text-center">ID</th>
                    <th colspan="1" class="text-center">Fecha</th>
                    <th colspan="1" class="text-center">Hora</th>
                    <th colspan="1" class="text-center">Paciente</th>
                    <th colspan="1" class="text-center">Optometra</th>
                    <th colspan="1" class="text-center">Acciones</th>
                </x-slot>
                <x-slot name='slot'>
                    @foreach ($citas as $cita)
                        <tr>
                            <td class="text-center">
                                {{ $cita->cit_id }}
                            </td>
                            <td class="text-center">
                                {{ $cita->cit_fecha }}
                            </td>
                            <td class="text-center">
                                {{ $cita->horarios->hor_inicio }} - {{ $cita->horarios->hor_fin }}
                            </td>
                            <td class="text-center">
                                {{ $cita->clientes->cli_nombre_completo }}
                            </td>
                            <td class="text-center">
                                {{ $cita->colaboradores->col_nombre_completo }}
                            </td>
                            <td class="text-center">
                                <x-link-icon btn="btn-info" icon="bi-eye-fill" title="Ver"
                                    href="{{ route('cita.show', $cita) }}" />
                                <x-link-icon btn="btn-warning" icon="bi-pencil-square" title="Editar"
                                    href="{{ route('cita.edit', $cita->cit_id) }}" />
                                <x-form-table id="form-delete-{{ $cita }}" method="POST"
                                    action="{{ route('cita.destroy', $cita) }}" role="form">
                                    @method('DELETE')
                                    <x-button-icon btn="btn-danger" icon="bi-trash fill" title="Eliminar"
                                        onclick="Eliminar({{ $cita->cit_id }})" />
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
