@extends('layouts.app')

@section('title', 'producto')
@section('title-page', 'Registrar Producto')

@push('styles')
@endpush

@section('content')

    @if (session('error'))
        <x-alert type="danger" message="{{ session('error') }}" />
    @endif

    <div class="card">
        <div class="card-body">
            <x-form id="store-productos" action="{{ route('producto.store') }}" method="POST">
                @include('producto.productos.form')
                <div class="row justify-content-end">
                    <div class="col-md-2 d-flex justify-content-end">
                        <x-button id="btn-store" btn="btn-primary" icon="bi-save" text="Guardar" />
                    </div>
                    <div class="col-md-2 d-flex justify-content-end">
                        <x-link-text-icon id="btn-cancel" btn="btn-danger" icon="bi-x-circle" text="Cancelar"
                            position="right" href="{{ route('producto.index') }}" />
                    </div>
                </div>
            </x-form>
        </div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript"></script>
@endpush
