<x-form class="card" id="update-tipoCategorias"
    action="{{ route('tipocategoria.update', ['tipocategoria' => $tipoCategoria]) }}" method="POST" role="form">
    @method('PUT')
    <div class="card-header">
        <div class="row justify-content-end">
            <div>
                <h5 id="title">Actualizar Tipo de Categoría</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('producto.tipocategorias.form')
    </div>
    <div class="card-footer">
        <div class="row justify-content-center">
            <div class="col-sm-5 text-center">
                <x-button type="submit" id="btn-update" btn="btn-primary" icon="bi-save" text="Actualizar" />
            </div>
            <div class="col-sm-5 text-center">
                <x-link-text-icon id="btn-cancel" btn="btn-danger" icon="bi-x-circle" text="Cancelar"
                    href="{{ route('tipocategoria.index') }}" />
            </div>
        </div>
    </div>
</x-form>
