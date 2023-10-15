@extends('layouts.app')

@section('title', 'Horario')

@push('styles')
@endpush

@section('content')

    {{-- NOTE: Mensaje de exito al realizar una accion --}}
    @if (session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif
    <div class="row justify-content-center flex-grow-1">
        <div class="col-xs-12 col-md-12 col-lg-5">
            @if ($horario->hor_id != null)
                @include('persona.horarios.edit')
            @else
                @include('persona.horarios.create')
            @endif
        </div>
        <div class="col-xs-12 col-md-12 col-lg-7">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <x-table id="table-horarios">
                            <x-slot name="header">
                                <th colspan="1" class="text-center">ID</th>
                                <th colspan="1" class="text-center">horario</th>
                                <th colspan="1" class="text-center">Acciones</th>
                            </x-slot>
                            <x-slot name='slot'>
                                @foreach ($horarios as $horario)
                                    <tr>
                                        <td class="text-center">
                                            {{ $horario->hor_id }}
                                        </td>
                                        <td class="text-center">
                                            {{ $horario->hor_inicio }} - {{ $horario->hor_fin }}
                                        </td>
                                        <td class="text-center">
                                            <x-button-icon btn="btn-info" icon="bi-eye-fill" title="Ver"
                                                onclick="Ver({{ $horario }})" />
                                            <x-form-table id="form-edit-{{ $horario->hor_id }}"
                                                action="{{ route('horario.index') }}" method="GET" role="search">
                                                <input type="hidden" name="search" value="{{ $horario->hor_id }}">
                                                <x-button-icon btn="btn-warning" icon="bi-pencil-square" title="Editar" />
                                            </x-form-table>

                                            <x-form-table id="form-delete-{{ $horario->hor_id }}"
                                                action="{{ route('horario.destroy', $horario) }}" method="POST" role="form">
                                                @method('DELETE')
                                                <x-button-icon btn="btn-danger" icon="bi-trash-fill" title="Eliminar"
                                                    onclick="Eliminar({{ $horario->hor_id }})" />
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
    @include('persona.horarios.show')
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(() => {});

        function Ver(horario) {
            $('#modal-showLabel').html('Ver horario');
            $('#hor_inicio-show').val(horario.hor_inicio);
            $('#hor_fin-show').val(horario.hor_fin);
            $('#modal-show').modal('show');
        }


        function Eliminar(id) {
            event.preventDefault();
            const form = $('#form-delete-' + id);
            $.post({
                url: '{{ route('horario.verificarEliminar') }}',
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
