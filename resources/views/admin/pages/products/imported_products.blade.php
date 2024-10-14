@extends('admin.layouts.default')
@section('title', 'Imported Products')
@section('content')
<!-- main stated -->
<main id="main" class="main">

    <style>
        .edit i {
            color: #4154F1;
            font-size: 20px;
            margin-right: 10px;
            margin-left: 10px;
        }

        .delete i {
            color: #E34724;
            font-size: 20px;
            margin-left: 10px;
        }

        .card-body table tr {
            background-color: #E34724 !important;
        }

        /* Custom CSS for DataTables buttons */
        .btn-blue {
            background-color: blue !important;
            color: white !important;
            border: none !important;
            border-radius: 5px !important;
            margin-right: 5px;
            font-weight: bold;
        }

        .btn-blue:hover {
            background-color: darkblue !important;
        }

        .table-stripe tbody tr:nth-child(odd) {
            background-color: lightblue;
        }

        .table-stripe tbody tr:nth-child(even) {
            background-color: deepskyblue;
        }
    </style>

    <div class="pagetitle">
        <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | Imported Products</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active"> Imported Products</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header mt-3" id="tbl_buttons" style="border: 0 !important; border-color: transparent !important;">
                    </div>
                    <div class="card-body">
                        <table id="tbl_data" class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>sku</th>
                                    <th>Inventory <span class="extra-text">(Available Qty)</span></th>
                                    <th>Barcode</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $key => $value)
                                <tr>
                                    <th style="vertical-align: middle; text-align: center;">{{ ++$key ?? ''}}</th>
                                    <td>
                                        <p class="fw-bold mb-1">{{ $value['title'] ?? ''}}</p>
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <p class="fw-normal mb-1">{{ $value['price'] ?? ''}}</p>
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <p class="fw-normal mb-1">{{ $value['sku'] ?? ''}}</p>
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <p class="text-muted mb-0">{{ $value['inventory_qty'] ?? ''}}</p>
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <p class="text-muted mb-0">{{ $value['barcode'] ?? ''}}</p>
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <span class="badge  {{($value['status'] == 'active') ? 'bg-success' : 'bg-danger' }}  rounded-pill d-inline">{{ ($value['status'] == 'active') ? 'Active' : 'Deactive' }} </span>
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <a class="edit" style="cursor: pointer;" title="Edit" data-id="{{$value['id']}}" data-toggle="tooltip">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="delete" style="cursor: pointer;" title="Delete" data-id="{{$value['id']}}" data-toggle="tooltip">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>

</main>
<!-- End #main -->
<form id="edit_form" action="{{route('admin.addProduct')}}" method="post">
    @csrf
    <input id="edit_form_id_input" type="hidden" value="" name="id">
    <input id="imported" type="hidden" value="yes" name="imported">
    <input id="duplicate" type="hidden" value="no" name="duplicate">
</form>
<!-- End #main -->

@stop

@pushOnce('scripts')
<script>
    $(function() {
        $("#tbl_data").DataTable({
            "paging": true,
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "pageLength": 100,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            "buttons": [{
                    extend: 'pdf',
                    text: 'PDF ',
                    className: 'btn-blue',
                },
                {
                    extend: 'excel',
                    text: 'Excel ',
                    className: 'btn-blue',
                },
                {
                    extend: 'print',
                    text: 'Print',
                    className: 'btn-blue',
                }
            ],
            "columnDefs": [{
                "targets": [3, 7],
                "searchable": false
            }]

        }).buttons().container().appendTo('#tbl_buttons');
    });
    $(document).ready(function() {
        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            $('#edit_form_id_input').val(id);
            $('#edit_form').submit();
        });

        $(document).on('click', '.delete', function() {
            var id = $(this).data('id');
            $('#edit_form_id_input').val(id);
            $('#duplicate').val('no');
            $('#edit_form').submit();
        });
    });
</script>
@endPushOnce