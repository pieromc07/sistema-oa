const departamentos = new Choices($('#dep_id')[0], {
    sorter: function (a, b) {
        return a.value > b.value ? 1 : a.value < b.value ? -1 : 0;
    }
});
const provincias = new Choices($('#pro_id')[0], {
    sorter: function (a, b) {
        return a.value > b.value ? 1 : a.value < b.value ? -1 : 0;
    }
});
const distritos = new Choices($('#dis_id')[0], {
    sorter: function (a, b) {
        return a.value > b.value ? 1 : a.value < b.value ? -1 : 0;
    }
});

$(document).ready(function () {

    $.ajax({
        url: "/departamentos",
        type: "get",
        success: function (data) {
            setDepartamentos(data);
        }
    });

    $('#dep_id').on('change', function () {
        let id = $(this).val();
        $.ajax({
            url: "/provincias",
            type: "get",
            data: {
                dep_id: id
            },
            success: function (data) {
                setProvincias(data);
                limpiarDistrito();
            }
        });

    });

    $('#pro_id').on('change', function () {
        let id = $(this).val();
        $.ajax({
            url: "/distritos",
            type: "get",
            data: {
                pro_id: id
            },
            success: function (data) {
                setDistritos(data);
            }
        });
    });

    function limpiarDistrito() {
        distritos.clearChoices();
        distritos.setChoices([{
            value: '',
            label: 'Seleccione Distrito',
            selected: true,
            disabled: true
        },])
    }

    function setDepartamentos(data) {
        departamentos.clearChoices();
        departamentos.setChoices([{
            value: '',
            label: 'Seleccione Departamento',
            selected: true,
            disabled: true,
        },])
        departamentos.setChoices(() => {
            return data.map((item) => {
                return {
                    value: item.dep_id,
                    label: item.dep_nombre
                };
            });
        });
    }

    function setProvincias(data) {
        provincias.clearChoices();
        provincias.setChoices([{
            value: '',
            label: 'Seleccione Provincia',
            selected: true,
            disabled: true
        },])
        provincias.setChoices(() => {
            return data.map((item) => {
                return {
                    value: item.pro_id,
                    label: item.pro_nombre
                };
            });
        });
    }

    function setDistritos(data) {
        distritos.clearChoices();
        distritos.setChoices([{
            value: '',
            label: 'Seleccione Distrito',
            selected: true,
            disabled: true
        },])
        distritos.setChoices(() => {
            return data.map((item) => {
                return {
                    value: item.dis_id,
                    label: item.dis_nombre
                };
            });
        });
    }
});

export const setSelect = (dep, pro, dis) => {
    departamentos.setChoiceByValue(dep);
    $('#dep_id').trigger('change');
    setTimeout(() => {
        provincias.setChoiceByValue(pro);
        $('#pro_id').trigger('change');
        setTimeout(() => {
            distritos.setChoiceByValue(dis);
        }, 900);
    }, 900);

}
