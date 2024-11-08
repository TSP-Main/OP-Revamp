@extends('admin.layouts.default')
@section('title', 'Question Categories')
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
        <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | Question Categories</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Question Categories</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header mt-3" id="tbl_button" style="border: 0 !important; border-color: transparent !important;">
                    </div>
                    <div class="card-body">
                        <table id="tbl_question_categories" class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="vertical-align: middle; text-align: center;">#</th>
                                    <th style="vertical-align: middle; text-align: center;">Name</th>
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
                                            <input class="form-check-input"  style="width: 3.3rem; height: 1.3rem;" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked />
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <a class="edit" style="cursor: pointer;" title="Edit" data-id="{{$value['id']}}"  data-toggle="tooltip">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="delete" style="cursor: pointer;" title="Delete" data-id="{{$value['id']}}"  data-toggle="tooltip">
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

<form  id="edit_form" action="{{route('admin.addQuestionCategory')}}" method="post">
    @csrf
    <input id="edit_form_id_input" type="hidden" value="" name="id">
</form>
<!-- End #main -->

@stop

@pushOnce('scripts')
<script>
    $(function() {
        $("#tbl_question_category").DataTable({
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
    $(document).ready(function () {
        $('.edit').click(function () {
            var id = $(this).data('id'); 
            $('#edit_form_id_input').val(id); 
            $('#edit_form').submit(); 
        });

        $('.delete').click(function () {
            var id = $(this).data('id'); 
            $('#edit_form_id_input').val(id); 
            $('#edit_form').submit();
        });
    });
</script>
@endPushOnce