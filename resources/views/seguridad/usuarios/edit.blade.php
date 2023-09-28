@extends('layouts.app')

@section('title', 'Usuario')


@push('styles')
@endpush

@section('content')
    @if (session('error'))
        <x-alert type="danger" message="{{ session('error') }}" />
    @endif
    <div class="card">
        <div class="card-body">
            <x-form id="update-usuarios" action="{{ route('usuario.update', ['usuario' => $usuario]) }}"
                method="POST" role="form">
                @method('PUT')
                @include('seguridad.usuarios.form')
                <div class="row justify-content-end">
                    <div class="col-md-2">
                        <x-button id="btn-update" btn="btn-primary" icon="bi-save" text="Actualizar" />
                    </div>
                    <div class="col-md-2">
                        <x-link-text-icon id="btn-cancel" btn="btn-danger" icon="bi-x-circle" text="Cancelar"
                            position="right" href="{{ route('usuario.index') }}" />
                    </div>
                </div>

            </x-form>
        </div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript"></script>
@endpush
