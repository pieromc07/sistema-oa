<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="text" id="description" name="description" placeholder="Descripción del Permiso"
        icon="bi-shield-fill-check" value="{{ $permiso->description }}" label="Descripción" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="text" id="name" name="name" placeholder="Nombre del Permiso" icon="bi-shield-lock-fill"
        value="{{ $permiso->name }}" label="Nombre" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="text" id="group" name="group" placeholder="Grupo del Permiso" icon="bi-shield-lock-fill"
        value="{{ $permiso->group }}" label="Grupo" />
</div>
