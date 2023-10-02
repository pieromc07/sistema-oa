<x-form class="card" id="store-marcas" action="{{ route('marca.store') }}" method="POST" role="form">
    <div class="card-header">
        <div class="row justify-content-end">
            <div>
                <h5 id="title">Crear Marca</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('producto.marcas.form')
    </div>
    <div class="card-footer">
        <div class="row justify-content-center">
            <div class="col-5 text-center">
                <x-button type="submit" id="btn-store" btn="btn-primary" icon="bi-save" text="Guardar" />
            </div>
            <div class="col-5 text-center">
                <x-button type="reset" id="btn-clear" btn="btn-danger" icon="bi-x-circle" text="Limpiar"
                    onclick="clear()" />
            </div>
        </div>
    </div>
</x-form>

@push('scripts')
    <script>
        function clear() {
            $('#mar_nombre').val('');
        }
    </script>
@endpush
