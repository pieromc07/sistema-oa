<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="text" id="pro_nombre" placeholder="Nombre" icon="bi-tag-fill" name="pro_nombre"
        value="{{ $producto->pro_nombre }}" />
</div>

<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="text" id="pro_descripcion" placeholder="Descripción" icon="bi-file-earmark-text-fill"
        name="pro_descripcion" value="{{ $producto->pro_descripcion }}" req="{{ false }}" />
</div>

<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="number" id="pro_stock" placeholder="Stock" icon="bi-boxes" name="pro_stock"
        value="{{ $producto->pro_stock }}" />
</div>

<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="number" id="pro_stock_minimo" placeholder="Stock Mínimo" icon="bi-exclamation-lg"
        name="pro_stock_minimo" value="{{ $producto->pro_stock_minimo }}" req="{{ false }}" />
</div>

<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="text" id="pro_codigo_barra" placeholder="Código de Barra" icon="bi-upc" name="pro_codigo_barra"
        value="{{ $producto->pro_codigo_barra }}" />
</div>

<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="number" min="0.00" max="10000.00" step="0.50" id="pro_precio_venta"
        placeholder="Precio de Venta" icon="bi-cash-coin" name="pro_precio_venta"
        value="{{ $producto->pro_precio_venta }}" />
</div>

<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="number" min="0.00" max="10000.00" step="0.50" id="pro_precio_compra"
        placeholder="Precio de Compra" icon="bi-cart-check-fill" name="pro_precio_compra"
        value="{{ $producto->pro_precio_compra }}" req="{{ false }}" />
</div>

<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="date" id="pro_fecha_vencimiento" placeholder="Fecha de Vencimiento" icon="bi-calendar-x-fill"
        name="pro_fecha_vencimiento" value="{{ $producto->pro_fecha_vencimiento }}" req="{{ false }}" />
</div>

<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-select id="cat_id" placeholder="Seleccione una categoría" name="cat_id">
        <x-slot name="options">
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->cat_id }}" {{ old('cat_id') == $categoria->cat_id ? 'selected' : '' }}
                    @if (isset($producto)) {{ $producto->cat_id == $categoria->cat_id ? 'selected' : '' }} @endif>
                    {{ $categoria->cat_nombre }}
                </option>
            @endforeach
        </x-slot>
    </x-select>
</div>

<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-select id="mar_id" placeholder="Seleccione una marca" name="mar_id">
        <x-slot name="options">
            @foreach ($marcas as $marca)
                <option value="{{ $marca->mar_id }}" {{ old('mar_id') == $marca->mar_id ? 'selected' : '' }}
                    @if (isset($producto)) {{ $producto->mar_id == $marca->mar_id ? 'selected' : '' }} @endif>
                    {{ $marca->mar_nombre }}
                </option>
            @endforeach
        </x-slot>
    </x-select>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(() => {

            const categorias = new Choices($('#cat_id')[0], {
                sorter: function(a, b) {
                    return a.value > b.value ? 1 : a.value < b.value ? -1 : 0;
                }
            });
            const marcas = new Choices($('#mar_id')[0], {
                sorter: function(a, b) {
                    return a.value > b.value ? 1 : a.value < b.value ? -1 : 0;
                }
            })

        });
    </script>
@endpush
