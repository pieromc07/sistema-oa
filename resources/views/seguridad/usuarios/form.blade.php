<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-select id="col_id" placeholder="Seleccione un Colaborador" icon="bi-card-list" name="col_id">
        <x-slot name="options">
            @foreach ($colaboradores as $colaborador)
                <option value="{{ $colaborador->col_id }}" {{ old('col_id') == $colaborador->col_id ? 'selected' : '' }}
                    @if (isset($usuario)) {{ $colaborador->col_id == $usuario->col_id ? 'selected' : '' }} @endif>
                    {{ $colaborador->col_nombres . ' ' . $colaborador->col_apellido_paterno . ' ' . $colaborador->col_apellido_materno }}
                </option>
            @endforeach
        </x-slot>
    </x-select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="text" id="usu_nombre" placeholder="Nombre de Usuario" icon="bi-person-fill" name="usu_nombre"
        value="{{ $usuario->usu_nombre }}" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="password" id="usu_contraseña" placeholder="Contraseña" icon="bi-person-fill" name="usu_contraseña"
        value="{{ $usuario->usu_contraseña }}" />
</div>
@if ($usuario->usu_id)
    <div class="col-xs-12 col-sm-12 col-lg-6">
        <x-select id="usu_estado" placeholder="Seleccione Estado" icon="bi-geo-alt-fill" name="usu_estado"
            label="Estado">
            <x-slot name="options">
                <option value="1"
                    @if ($usuario->usu_estado == 1 ) selected @endif>
                    Activo
                </option>
                <option value="0" 
                    @if ($usuario->usu_estado == 0 ) selected @endif>
                    Inactivo
                </option>
            </x-slot>
        </x-select>
    </div>
@endif

<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-select id="rol_id" placeholder="Seleccione un Rol" icon="bi-card-list" name="rol_id">
        <x-slot name="options">
            @foreach ($roles as $rol)
                <option value="{{ $rol->id }}" @if ($role->id == $rol->id) selected @endif>
                    {{ $rol->name }}
                </option>
            @endforeach
        </x-slot>
    </x-select>
</div>
