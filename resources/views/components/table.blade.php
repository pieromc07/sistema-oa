@props(['id'])

@php
    $id = $id ?? md5('table' . rand(1, 1000));
@endphp



<table class="table table-striped" id="{{ $id }}">
    <thead>
        <tr>
            {{ $header }}
        </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/compiled/css/table-datatable-jquery.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendor/libs/datatables.net-bs5/css/buttons.dataTables.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/vendor/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script type="text/javascript" language="javascript"
        src="{{ asset('assets/vendor/libs/datatables.net-bs5/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" language="javascript"
        src="{{ asset('assets/vendor/libs/datatables.net-bs5/js/jszip.min.js') }}"></script>
    <script type="text/javascript" language="javascript"
        src="{{ asset('assets/vendor/libs/datatables.net-bs5/js/pdfmake.min.js') }}"></script>
    <script type="text/javascript" language="javascript"
        src="{{ asset('assets/vendor/libs/datatables.net-bs5/js/vfs_fonts.js') }}"></script>
    <script type="text/javascript" language="javascript"
        src="{{ asset('assets/vendor/libs/datatables.net-bs5/js/buttons.html5.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#{{ $id }}').DataTable({
                order: [0, 'desc'],
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    // 'csvHtml5',
                    'pdfHtml5',
                ],
                "language": {
                    "url": "{{ asset('assets/vendor/libs/datatables.net-bs5/js/Spanish.json') }}"
                },
                "lengthMenu": [5, 10, 25, 50, "Todos"]
            });
        });
    </script>
@endpush
