<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="text" id="description" name="description" placeholder="Descripción del Rol" icon="bi-shield-fill-check"
        value="{{ $rol->description }}" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="text" id="name" name="name" placeholder="Nombre del rol" icon="bi-shield-lock-fill"
        value="{{ $rol->name }}" />
</div>

{{-- Listado de permisos --}}
<div class="col-xs-12 col-sm-12 col-lg-12 mt-3">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <h6 class="text-start">
                Asignar Permisos
            </h6>
        </div>

        <div class="col-xs-12 col-sm-12 col-lg-12">
            <div class="row justify-content-between mt-3 mb-3 align-items-center">
                @foreach ($permissions as $permission)
                    <div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
                        <button class="btn btn-primary btn-sm btn-block text-uppercase" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $permission[0]->group }}" aria-expanded="false"
                            aria-controls="collapse{{ $permission[0]->group }}">
                            {{ $permission[0]->group }}
                            <span class="badge bg-secondary">{{ count($permission) }}</span>
                        </button>
                        <ul class="list-group collapse" id="collapse{{ $permission[0]->group }}">
                            <li class="list-group-item">
                                <input type="checkbox"
                                    id="permission_{{ $permission[0]->group }}" onclick="checkAll(this)"
                                    value="{{ $permission[0]->group }}"
                                    @if (count($rol->permissions->where('group', $permission[0]->group)) == count($permission)) checked @endif>
                                <label for="permission_all_{{ $permission[0]->group }}">
                                    Todos los permisos
                                </label>

                            </li>
                            @foreach ($permission as $item)
                                <li class="list-group-item">
                                    <input type="checkbox" name="permissions[]" id="permission_{{ $permission[0]->group }}_{{ $item->id }}"
                                        value="{{ $item->id }}" @if ($rol->permissions->contains($item->id)) checked @endif>
                                    <label for="permission{{ $item->id }}">
                                        {{ $item->description }}
                                    </label>

                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        function checkAll(element) {
            let id = element.id
            let AllCheckbox = document.querySelectorAll(`input[id^="${id}"]`)
            if (element.checked) {
                AllCheckbox.forEach((item) => {
                    item.checked = true
                })
            } else {
                AllCheckbox.forEach((item) => {
                    item.checked = false
                })
            }
        }
    </script>
@endpush
