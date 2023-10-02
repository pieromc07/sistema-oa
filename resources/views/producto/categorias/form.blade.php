<div class="col-xs-12 col-sm-12 col-lg-12">
    <x-input type="text" id="cat_nombre" name="cat_nombre" placeholder="Descripción de la Categoría"
        icon="bi-shield-fill-check" value="{{ $categoria->cat_nombre }}" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-12">
    <x-select id="tic_id" placeholder="Seleccione un tipo de Categoría" icon="bi bi-grid" name="tic_id">
        <x-slot name="options">
            @foreach ($tipoCategorias as $tipoCat)
                <option value="{{ $tipoCat->tic_id }}" {{ old('tic_id') == $tipoCat->tic_id ? 'selected' : '' }}
                    @if (isset($categoria)) {{ $categoria->tic_id == $tipoCat->tic_id ? 'selected' : '' }} @endif>
                    {{ $tipoCat->tic_nombre }}
                </option>
            @endforeach
        </x-slot>
    </x-select>
</div>
