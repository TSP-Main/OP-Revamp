@extends('admin.layouts.default')
@section('title', 'FAQ Questions')
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
        <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | FAQ Questions</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">FAQ Questions</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header mt-3 " id="tbl_buttons" style="border: 0 !important; border-color: transparent !important;">
                        <div class="row mb-3 px-4">
                            <div class="col-md-4 d-block">
                                <label for="category" class="form-label fw-bold">Filter by Product</label>
                                <select id="category" class="form-select select2" data-placeholder="choose category name ..." required>
                                    <option value="All">All</option>
                                    @foreach ($products ?? [] as $key => $pro)
                                    <option value="{{ $pro}}">{{ $pro}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 text-center d-block">
                                <label for="search" class="form-label fw-bold">Search </label>
                                <input type="text" id="search" class="form-control py-2">
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tbl_data" class="table table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="vertical-align: middle; text-align: center;">#</th>
                                        <th style="vertical-align: middle; text-align: center;">Order</th>
                                        <th style="vertical-align: middle; text-align: center;">Title</th>
                                        <th style="vertical-align: middle; text-align: center;">product title</th>
                                        <th style="vertical-align: middle; text-align: center;">Status</th>
                                        <th style="vertical-align: middle; text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $key => $value)
                                    <tr>
                                        <td style="vertical-align: middle; text-align: center;"> {{ ++$key }} </td>
                                        <td style="vertical-align: middle; text-align: center; "> {{ $value['order'] ?? '' }}</td>
                                        <td style="vertical-align: middle; text-align: center; width:30% !important; "> {{ $value['title'] ?? '' }}</td>
                                        <td style="vertical-align: middle; text-align: center; font-weight:700;"> {{$value['product_title']??''}}</td>
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
            "pageLength": 50,
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