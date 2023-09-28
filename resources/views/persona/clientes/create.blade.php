@extends('layouts.app')

@section('title', 'Clientes')

@push('styles')
@endpush

@section('content')

    @if (session('error'))
        <x-alert type="danger" message="{{ session('error') }}" />
    @endif

    <div class="card">
        <div class="card-body">
            <x-form id="store-clientes" action="{{ route('cliente.store') }}" method="POST">
                @include('persona.clientes.form')
                <div class="row justify-content-end">
                    <div class="col-md-2 d-flex justify-content-end">
                        <x-button id="btn-store" btn="btn-primary" icon="bi-save" text="Guardar" />
                    </div>
                    <div class="col-md-2 d-flex justify-content-end">
                        <x-link-text-icon id="btn-cancel" btn="btn-danger" icon="bi-x-circle" text="Cancelar"
                            position="right" href="{{ route('cliente.index') }}" />
                    </div>
                </div>
            </x-form>
        </div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript"></script>
@endpush
