export const eliminacion = (route, id) => {
    Swal.fire({
        title: '¿Está seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: `{{route('${route}', ':id')}}`.replace(':id', id),
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: (res) => {
                    Swal.fire(
                        '¡Eliminado!',
                        'El registro ha sido eliminado.',
                        'success'
                    )
                    location.reload();
                }
            });

        }
    })
}
