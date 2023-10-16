<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
    <x-select id="col_id" placeholder="Seleccione Optometra" icon="bi-geo-alt-fill" name="col_id" label="Optometra">
        <x-slot name="options">
            @foreach ($colaboradores as $colaborador)
                <option value="{{ $colaborador->col_id }}" {{ old('col_id') == $colaborador->col_id ? 'selected' : '' }}
                    @if (isset($cita)) {{ $cita->col_id == $colaborador->col_id ? 'selected' : '' }} @endif>
                    {{ $colaborador->col_nombre_completo }}
                </option>
            @endforeach
        </x-slot>
    </x-select>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
    <x-input id="cit_fecha" placeholder="Ingrese Fecha" icon="bi-calendar3" type="date" name="cit_fecha"
        label="Fecha" value="{{ $cita->cit_fecha ?? old('cit_fecha') }}" />
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
    <x-input id="cit_hora" placeholder="Ingrese Hora" icon="bi-clock" type="time" name="cit_hora" label="Hora"
        value="{{ $cita->cit_hora ?? old('cit_hora') }}" />
