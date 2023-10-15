<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-select id="tdo_id" placeholder="Tipo de Documento" icon="bi-card-list" name="tdo_id">
        <x-slot name="options">
            @foreach ($tipoDocumentos as $tipoDocumento)
                <option value="{{ $tipoDocumento->tdo_id }}"
                    {{ old('tdo_id') == $tipoDocumento->tdo_id ? 'selected' : '' }}
                    @if (isset($cliente)) {{ $cliente->tdo_id == $tipoDocumento->tdo_id ? 'selected' : '' }} @endif>
                    {{ $tipoDocumento->tdo_nombre }}
                </option>
            @endforeach
        </x-slot>
    </x-select>
</div>
<!-- NOTE: Busqueda a Reniec -->
<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input-load type="number" id="cli_numero_documento" placeholder="Número de Documento" icon="bi-card-list"
        name="cli_numero_documento" value="{{ $cliente->cli_numero_documento }}" label="Numero de Documento"
        type="text" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="text" id="cli_nombre_completo" placeholder="Nombre Completo" icon="bi-person-fill"
        name="cli_nombre_completo" value="{{ $cliente->cli_nombre_completo }}" />
</div>

<!-- NOTE: Fin Busqueda a Reniec -->
<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="text" id="cli_direccion" placeholder="Dirección" icon="bi-geo-alt-fill" name="cli_direccion"
        value="{{ $cliente->cli_direccion }}" label="Dirección" req="{{ false }}" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="text" id="cli_celular" placeholder="Celular" icon="bi-phone-fill" name="cli_celular"
        value="{{ $cliente->cli_celular }}" label="Celular" req="{{ false }}" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-select id="dep_id" placeholder="Seleccione Departamento" icon="bi-geo-alt-fill" name="dep_id"
        label="Departamento">
        <x-slot name="options">
        </x-slot>
    </x-select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-select id="pro_id" placeholder="Seleccione Provincia" icon="bi-geo-alt-fill" name="pro_id" label="Provincia">
        <x-slot name="options">
        </x-slot>
    </x-select>
</div>

<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-select id="dis_id" placeholder="Seleccione Distrito" icon="bi-geo-alt-fill" name="dis_id" label="Distrito">
        <x-slot name="options">
        </x-slot>
    </x-select>
</div>
@push('scripts')
    <script type="module">
        import {
            setSelect
        } from "{{ asset('scripts/ciudades.js') }}";

        let dep = 0;
        let pro = 0;
        let dis = 0;
        let isEdit = {{ isset($cliente) ? 'true' : 'false' }};
        if (isEdit) {
            dep = {{ $cliente->dep_id ?? '0' }};
            pro = {{ $cliente->pro_id ?? '0' }};
            dis = {{ $cliente->dis_id ?? '0' }};
        } else {
            dep = {{ old('dep_id') ?? '0' }};
            pro = {{ old('pro_id') ?? '0' }};
            dis = {{ old('dis_id') ?? '0' }};
        }

        console.log(dep, pro, dis);

        @error('dep_id')
            dep = {{ old('dep_id') }};
        @enderror
        @error('pro_id')
            pro = {{ old('pro_id') }};
        @enderror
        @error('dis_id')
            dis = {{ old('dis_id') }};
        @enderror


        if (dep != 0 && pro != 0 && dis != 0) {
            setTimeout(() => {
                setSelect(dep, pro, dis);
            }, 1000);
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {


            $('#cli_numero_documento').keyup(function() {
                let tipo = $('#tdo_id').val();
                let numero = $(this).val();
                if (tipo == "")
                    messageAlert("Seleccione un tipo de documento", "#ffc107", "#000");
                else
                    BuscarDniRuc(tipo, numero);
            });
        });

        function messageAlert(message, background, color) {
            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "center",
                style: {
                    background: background,
                    color: color,
                }
            }).showToast()
        }

        // NOTE: Funcion para buscar en la API de Reniec
        function BuscarDniRuc(tipo, numero) {
            const TOKEN =
                'I5Q2isdGve4xgTW53inHchckBvpTNnWeLaiDmN4isvuriO8cPAMwriqz5F1U';
            const URL = 'https://api.migo.pe/api/v1/';
            if (tipo == 1 && numero.length == 8) {
                $.ajax({
                    url: URL + 'dni',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        dni: numero,
                        token: TOKEN
                    },
                    success: function(data) {
                        if (data.success) {
                            $('#cli_nombre_completo').val(data.nombre);
                            $('#cli_numero_documento-spinner').addClass('d-none');
                            $('#cli_numero_documento-icon').removeClass('d-none');
                        } else {
                            messageAlert(data.message, "#ffc107", "#000");
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        messageAlert("Error al consultar el DNI", "#dc3545", "#fff");
                    }
                });
            } else if (tipo == 2 && numero.length == 11) {
                $.ajax({
                    url: URL + 'ruc',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        ruc: numero,
                        token: TOKEN
                    },
                    success: function(data) {
                        if (data.success) {
                            $('#cli_nombre_completo').val(data.nombre_o_razon_social);
                            $('#cli_direccion').val(data.direccion);
                            $('#cli_numero_documento-spinner').addClass('d-none');
                            $('#cli_numero_documento-icon').removeClass('d-none');
                        } else {
                            messageAlert(data.message, "#ffc107", "#000");
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        messageAlert("Error al consultar el RUC", "#dc3545", "#fff");
                    }
                });

            } else if (numero.length > 0 && numero.length != 8) {
                $('#cli_nombre_completo').val('');
                $('#cli_numero_documento-icon').addClass('d-none');
                $('#cli_numero_documento-spinner').removeClass('d-none');
            } else if (numero.length === 0) {
                $('#cli_nombre_completo').val('');
                $('#cli_numero_documento-spinner').addClass('d-none');
                $('#cli_numero_documento-icon').removeClass('d-none');
            }
        }
        // NOTE: Fin Funcion para buscar en la API de Reniec
    </script>
@endpush
