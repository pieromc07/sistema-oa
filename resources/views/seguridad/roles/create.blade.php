@extends('layouts.app')

@section('title', 'roles')
@section('title-page', 'Registrar Rol')

@push('styles')
@endpush

@section('content')

    @if (session('error'))
        <x-alert type="danger" message="{{ session('error') }}" />
    @endif

    <div class="card">
        <div class="card-body">
            <x-form id="store-roles" action="{{ route('rol.store') }}" method="POST">

                @include('seguridad.roles.form')

                <div class="row justify-content-end">
                    <div class="col-md-2">
                        <x-button id="btn-update" btn="btn-primary" icon="bi-save" text="Registrar" />
                    </div>
                    <div class="col-md-2">
                        <x-link-text-icon id="btn-cancel" btn="btn-danger" icon="bi-x-circle" text="Cancelar"
                            position="right" href="{{ route('rol.index') }}" />
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
