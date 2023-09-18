@extends('layouts.app')

@section('title', 'roles')
@section('title-page', 'Actualizar Rol')

@push('styles')
@endpush

@section('content')

    @if (session('error'))
        <x-alert type="danger" message="{{ session('error') }}" />
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row">
                @include('seguridad.roles.form')
                <div class="row justify-content-end">
                    <div class="col-md-2">
                        <x-link-text-icon id="btn-regresar" btn="btn-danger" icon="bi-arrow-left-circle" text="Regresar"
                            position="left" href="{{ route('rol.index') }}" />
                    </div>
                </div>
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
