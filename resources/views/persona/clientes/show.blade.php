@extends('layouts.app')

@section('title', 'Clientes')


@push('styles')
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                @include('persona.clientes.form')
                <div class="row justify-content-end">
                    <div class="col-md-2">
                        <x-link-text-icon id="btn-regresar" btn="btn-danger" icon="bi-arrow-left-circle" text="Regresar"
                            position="left" href="{{ route('cliente.index') }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript"></script>
@endpush
