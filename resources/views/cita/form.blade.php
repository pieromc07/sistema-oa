<div class="col-xs-12 col-sm-12 col-lg-3">
    <x-select id="tdo_id" placeholder="Tipo de Documento" icon="bi-card-list" name="tdo_id">
        <x-slot name="options">
            @foreach ($tipoDocumentos as $tipoDocumento)
                <option value="{{ $tipoDocumento->tdo_id }}"
                    {{ old('tdo_id') == $tipoDocumento->tdo_id ? 'selected' : '' }}
                    @if (isset($colaborador)) {{ $colaborador->tdo_id == $tipoDocumento->tdo_id ? 'selected' : '' }} @endif>
                    {{ $tipoDocumento->tdo_nombre }}
                </option>
            @endforeach
        </x-slot>
    </x-select>
</div>
<!-- NOTE: Busqueda a Reniec -->
<div class="col-xs-12 col-sm-12 col-lg-3">
    <x-input-load type="number" id="cli_numero_documento" placeholder="Número de Documento" icon="bi-card-list"
        name="cli_numero_documento" value="{{ $cliente->cli_numero_documento }}" label="Numero de Documento"
        type="text" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-6">
    <x-input type="text" id="cli_nombre_completo" placeholder="Nombres" icon="bi-person-fill"
        name="cli_nombre_completo" value="{{ $cliente->cli_nombre_completo }}" />
</div>
<!-- NOTE: Fin Busqueda a Reniec -->
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
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
<div class="col-xs-12 col-sm-12 col-lg-4">
    <x-select id="dep_id" placeholder="Seleccione Departamento" icon="bi-geo-alt-fill" name="dep_id"
        label="Departamento">
        <x-slot name="options">
        </x-slot>
    </x-select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4">
    <x-select id="pro_id" placeholder="Seleccione Provincia" icon="bi-geo-alt-fill" name="pro_id" label="Provincia">
        <x-slot name="options">
        </x-slot>
    </x-select>
</div>

<div class="col-xs-12 col-sm-12 col-lg-4">
    <x-select id="dis_id" placeholder="Seleccione Distrito" icon="bi-geo-alt-fill" name="dis_id" label="Distrito">
        <x-slot name="options">
        </x-slot>
    </x-select>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
    <x-input id="cit_fecha" placeholder="Ingrese Fecha" icon="bi-calendar3" type="date" name="cit_fecha"
        label="Fecha" value="{{ $cita->cit_fecha ?? old('cit_fecha') }}" />
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
    <x-select id="hor_id" placeholder="Seleccione Horario" icon="bi-clock" name="hor_id" label="Horario">
        <x-slot name="options">

        </x-slot>
    </x-select>
</div>
@push('scripts')
<script type="module">
    import {
        setSelect
    } from "{{ asset('scripts/ciudades.js') }}";

    let dep = {{ $colaborador->dep_id ?? '0' }};
    let pro = {{ $colaborador->pro_id ?? '0' }};
    let dis = {{ $colaborador->dis_id ?? '0' }};

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
            function messageAlert(message, background) {
                Toastify({
                    text: message,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "center",
                    backgroundColor: background,
                }).showToast()
            }

            $('#cli_numero_documento').keyup(function() {
                let tipo = $('#tdo_id').val();
                let numero = $(this).val();
                if (tipo == "")
                    messageAlert("Seleccione un tipo de documento", "#ffc107");
                else
                    BuscarDniRuc(tipo, numero);
            });

            $('#cit_fecha').change(function() {
                let fecha = $(this).val();
                $.ajax({
                    url: "{{ url('api/horarios') }}/" + fecha,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.length > 0) {
                            $('#hor_id').empty();
                            $('#hor_id').append('<option value="">Seleccione Horario</option>');
                            $.each(data, function(index, value) {
                                $('#hor_id').append('<option value="' + value.hor_id +
                                    '">' + value.inicio +
                                    ' - ' + value.fin + '</option>');
                            });
                            messageAlert("Horarios disponibles", "#28a745");
                        } else {
                            console.log(data);
                            $('#hor_id').empty();
                            $('#hor_id').append('<option value="">Seleccione Horario</option>');
                            messageAlert("No hay horarios disponibles", "#ffc107");
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        messageAlert("Error al consultar el horario", "#dc3545");
                    }
                });

            });

            $('#store-citas').submit(function(e) {
                e.preventDefault();
                let tdo_id = $('#tdo_id').val();
                let cli_numero_documento = $('#cli_numero_documento').val();
                let cli_nombre_completo = $('#cli_nombre_completo').val();
                let col_id = $('#col_id').val();
                let cit_fecha = $('#cit_fecha').val();
                let hor_id = $('#hor_id').val();
                let dis_id = $('#dis_id').val();
                if (tdo_id == "") {
                    messageAlert("Seleccione un tipo de documento", "#ffc107");
                    return false;
                } else if (cli_numero_documento == "") {
                    messageAlert("Ingrese un numero de documento", "#ffc107");
                    return false;
                } else if (cli_nombre_completo == "") {
                    messageAlert("Ingrese un nombre completo", "#ffc107");
                    return false;
                } else if (col_id == "") {
                    messageAlert("Seleccione un optometra", "#ffc107");
                    return false;
                } else if (cit_fecha == "") {
                    messageAlert("Seleccione una fecha", "#ffc107");
                    return false;
                } else if (hor_id == "") {
                    messageAlert("Seleccione un horario", "#ffc107");
                    return false;
                }else if (dis_id == "") {
                    messageAlert("Seleccione un distrito", "#ffc107");
                    return false;
                } else {
                    const form = $(this);
                    const url = form.attr('action');
                    const data = {
                        tdo_id: tdo_id,
                        cli_numero_documento: cli_numero_documento,
                        cli_nombre_completo: cli_nombre_completo,
                        col_id: col_id,
                        cit_fecha: cit_fecha,
                        hor_id: hor_id,
                        dis_id: dis_id,
                        _token: "{{ csrf_token() }}"
                    }
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'JSON',
                        data: data,
                        success: function(data) {
                            console.log(data);
                            if (data.success) {
                                messageAlert(data.message, "#28a745");
                                setTimeout(function() {
                                    window.location.href = "{{ route('cita.index') }}";
                                }, 3000);
                            } else {
                                messageAlert(data.message, "#ffc107");
                            }
                        },
                        error: function(data) {
                            console.log(data);
                            messageAlert("Error al registrar la cita", "#dc3545");
                        }
                    });
                }
            });
        });

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
