@extends('admin.layouts.default')
@section('title', 'Main Categories')
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

        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
            visibility: hidden;
        }
    </style>

    <div class="pagetitle">
        <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | Main Categories</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Main Categories</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header mt-3" id="tbl_button" style="border: 0 !important; border-color: transparent !important;">
                    </div>
                    <div class="row mb-3 px-4">
                        <div class="col-md-10 mt-3 text-center d-block">
                            <label for="search" class="form-label fw-bold">Search From Table </label>
                            <input type="text" id="search" placeholder="Search here..." class="form-control py-2">
                        </div>
                        <div class="col-md-2  mt-3 text-center d-block">
                            <label class="form-label fw-bold">Trash</label>
                            <a href="{{route('admin.categoriesTrash',['cat_type' => 'category_id'])}}" class="form-control btn btn-success py-2 fw-bold">Go to Trash</a>
                        </div>
                        <div class="col-md-12 mt-3 ">
                            <div id="ajax_alert" class="alert alert-danger d-none text-light border-0 alert-dismissible fade show" role="alert">
                                <h4 id="status">Success</h4>
                                <p style="margin-bottom: 0.5rem;" id="alert_msg">Category Successfully deleted.!</p>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tbl_data" class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="vertical-align: middle; text-align: center;">#</th>
                                    <th style="vertical-align: middle; text-align: center;">Category Name</th>
                                    <th style="vertical-align: middle; text-align: center;">Status</th>
                                    <th style="vertical-align: middle; text-align: center;">Active/Inactive</th>
                                    <th style="vertical-align: middle; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $key => $value)
                                <tr>
                                    <th style="vertical-align: middle; text-align: center;">{{ ++$key }}</th>
                                    <td style="vertical-align: middle; text-align: center;">{{$value['name'] ?? '' }}</td>
                                    <td style="vertical-align: middle; text-align: center; font-weight: bold;">{{$value['publish'] ?? '' }} </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <div class="form-check form-switch d-flex justify-content-center ">
                                            <input class="form-check-input" style="width: 3.3rem; height: 1.3rem;" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked />
                                        </div>
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

<form id="edit_form" action="{{route('admin.addCategory')}}" method="post">
    @csrf
    <input id="edit_form_id_input" type="hidden" value="" name="id">
    <input id="selection" type="hidden" value="1" name="selection">
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
            "pageLength": 50,
            "buttons": [{
                    extend: 'pdf',
                    text: 'Donwload PDF ',
                    className: 'btn-blue',
                },
                {
                    extend: 'print',
                    text: 'Print Out',
                    className: 'btn-blue',
                }
            ]
        }).buttons().container();
    });

    $(document).ready(function() {
        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            $('#edit_form_id_input').val(id);
            $('#edit_form').submit();
        });

        var tableApi = $('#tbl_data').DataTable();
        $('#search').on('input', function() {
            let text = $(this).val();
            if (text === '') {
                tableApi.search('').draw();
            } else {
                tableApi.search(text).draw();
            }
        });

        $(document).on('click', '.delete', function() {
            $('#ajax_alert').addClass('d-none').removeClass('bg-success').removeClass('bg-danger');
            var $id = $(this).data('id');
            var $cat_type = 'category_id';

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('id', $id);
            formData.append('cat_type', $cat_type);
            formData.append('status', 'Deactive');
            var $rowToDelete = $(this).closest('tr');

            $.ajax({
                url: "{{ route('admin.dellCategory') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 'Success') {
                        $rowToDelete.fadeOut('slow', function() {
                            $(this).remove();
                        });
                    }
                    $('#ajax_alert').removeClass('d-none').addClass(response.data.class);
                    $('#status').text(response.status);
                    $('#alert_msg').text(response.message);

                },
                error: function(error) {
                    alert('Contact To Developer');
                }
            });
        });
    });
</script>
@endPushOnce