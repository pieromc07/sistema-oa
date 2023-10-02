<x-modal id="modal-show">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="modal-showLabel">
                Ver Modelo
            </h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <i class="bi bi-x"></i>
        </div>
        <div class="modal-body">
            <div class="row">
                @include('producto.tipocategorias.form-show')
            </div>
        </div>
        <div class="modal-footer">
            <x-button id="btn-close-modal" btn="btn-secondary" title="Cerrar" data-bs-dismiss="modal" position="left"
                text="Cerrar" icon="bi-x-circle" />
        </div>
    </div>
</x-modal>
