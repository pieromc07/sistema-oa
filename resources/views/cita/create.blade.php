@extends('layouts.app')

@section('title', 'Citas')

@push('styles')
@endpush

@section('content')

    <div class="card">
        <div class="card-body">
            <x-form id="store-citas" action="{{ route('cita.store') }}" method="POST">
                @include('cita.form')
                <div class="row justify-content-end">
                    <div class="col-md-2 d-flex">
                        <x-button id="btn-store" btn="btn-primary" icon="bi-save" text="Guardar" />
                    </div>
                    <div class="col-md-2 d-flex">
                        <x-link-text-icon id="btn-cancel" btn="btn-danger" icon="bi-x-circle" text="Cancelar"
                            position="right" href="{{ route('cita.index') }}" />
                    </div>
                </div>

            </x-form>
        </div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript"></script>
@endpush
