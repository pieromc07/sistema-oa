@extends('layouts.app')

@section('title', 'permisos')
@section('title-page', 'Actualizar Permiso')

@push('styles')
@endpush

@section('content')

    @if (session('error'))
        <x-alert type="danger" message="{{ session('error') }}" />
    @endif

    <div class="card">
        <div class="card-body">
            <x-form id="update-permisos" action="{{ route('permiso.update', ['permiso' => $permiso]) }}" method="POST">
                @method('PUT')
                @include('seguridad.permisos.form')
                <div class="row justify-content-end">
                    <div class="col-md-2">
                        <x-button id="btn-update" btn="btn-primary" icon="bi-save" text="Actualizar" />
                    </div>
                    <div class="col-md-2">
                        <x-link-text-icon id="btn-cancel" btn="btn-danger" icon="bi-x-circle" text="Cancelar"
                            position="right" href="{{ route('permiso.index') }}" />
                    </div>
                </div>
            </x-form>
        </div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(() => {

        });
    </script>
@endpush
