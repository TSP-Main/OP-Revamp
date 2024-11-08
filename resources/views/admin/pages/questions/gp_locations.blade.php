@extends('admin.layouts.default')
@section('title', 'GP Locations')
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

        .select2-selection__rendered {
            line-height: 35px !important;
        }

        .select2-container .select2-selection--single {
            height: 40px !important;
        }

        .select2-selection__arrow {
            height: 40px !important;
        }

        .btn_theme {
            background: #03bd8d;
            border: #03bd8d 1px solid;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
            visibility: hidden;
        }
    </style>

    <div class="pagetitle">
        <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | GP Locations</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">GP Locations</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header mt-3 " id="tbl_buttons" style="border: 0 !important; border-color: transparent !important;">
                        <div class="row mb-3 px-4">

                            <div class="col-md-12 text-center d-block">
                                <label for="search" class="form-label fw-bold">Search From Table </label>
                                <input type="text" id="search" class="form-control py-2">
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tbl_data" class="table table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="vertical-align: middle; text-align: center;">#</th>
                                        <th style="vertical-align: middle; text-align: center;">GP Locaction Address</th>
                                        <th style="vertical-align: middle; text-align: center;">GP Locaction Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gp_locations as $key => $value)
                                    <tr>
                                        <td style="vertical-align: middle; text-align: center;"> {{ ++$key }} </td>
                                        <td><strong>{{$value['b']}}</strong>,{{$value['e'] }}<br />{{$value['f'] }},{{$value['g']}}<br />{{$value['h']}} {{$value['i']}}</td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            <input class="form-control" type="email" id="gpa_email_{{$value['id']}}" value="">
                                        </td>
                                        <th style="vertical-align: middle; text-align: center;">
                                            <button type="button" data-id="{{$value['id']}}" class="btn btn-small bg-primary  rounded-pill text-center download_gpa">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                        </th>
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
<form id="edit_form" action="{{route('admin.addfaqQuestion')}}" method="post">
    @csrf
    <input id="edit_form_id_input" type="hidden" value="" name="id">
</form>
<!-- End #main -->


@stop

@pushOnce('scripts')
<script>
    $(function() {
        var table = $("#tbl_data").DataTable({
            "paging": true,
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": true,
            "ordering": true,
            "info": true,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            "buttons": [{
                    extend: 'pdf',
                    text: 'Donwload PDF ',
                    className: 'btn-blue',
                },
                // {
                //     extend: 'excel',
                //     text: 'Donwload Excel ',
                //     className: 'btn-blue', 
                // },

                {
                    extend: 'print',
                    text: 'Print Out',
                    className: 'btn-blue',
                }
            ]
        }).buttons().container();

    });
    $(document).ready(function() {
        var tableApi = $('#tbl_data').DataTable();
        $('#category').on('change', function() {
            var category = $(this).val();
            if (category == 'All') {
                tableApi.column(3).search('').draw();
            } else {
                tableApi.column(3).search(category).draw();
            }
        });


        $('#search').on('input', function() {
            let text = $(this).val();
            if (text === '') {
                tableApi.search('').draw();
            } else {
                tableApi.search(text).draw();
            }
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            $('#edit_form_id_input').val(id);
            $('#edit_form').submit();
        });

        $(document).on('click', '.delete', function() {
            var id = $(this).data('id');
            $('#edit_form_id_input').val(id);
            $('#edit_form').submit();
        });
    });
</script>
@endPushOnce