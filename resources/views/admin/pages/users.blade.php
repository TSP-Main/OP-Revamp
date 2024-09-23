@extends('admin.layouts.default')
@section('title', 'UserSeeder')
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
        <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | Users</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header mt-3 d-none" id="tbl_buttons" style="border: 0 !important; border-color: transparent !important;">
                    </div>
                    <div class="card-body mt-5">
                        <table id="tbl_data" class="table table-striped">
                            <thead class="thead-dark">
                                <tr style="vertical-align: middle; text-align: center;">
                                    <th>details</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <!--<th>Actions</th>-->
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($users as $key => $value)
                                <tr>
                                    <th style="vertical-align: middle; text-align: center;">{{ ++$key ?? ''}}</th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://mdbootstrap.com/img/new/avatars/6.jpg" class="rounded-circle" alt="" style="width: 45px; height: 45px" />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">{{ $value['name'] ?? ''}}</p>
                                                <p class="text-muted mb-0">{{ $value['email'] ?? ''}}</p>
                                            </div>
                                        </div>

                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <p class="fw-normal mb-1">{{ $value['phone'] ?? ''}}</p>
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <p class="text-muted mb-0">{{ $value['address'] ?? ''}}</p>
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <span class="badge  {{($value['status'] == 1) ? 'bg-success' : 'bg-danger'; }}  rounded-pill d-inline">{{ ($value['status'] == 1) ? 'Active' : 'Deactive'; }} </span>
                                    </td>
                                    <!--<td style="vertical-align: middle; text-align: center;">-->
                                        <!-- <a class="edit" style="cursor: pointer;" title="Edit" data-id="{{$value['id']}}" data-toggle="tooltip">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                        <!--<a class="delete" style="cursor: pointer;" title="Delete" data-id="{{$value['id']}} data-toggle=" tooltip">-->
                                        <!--    <i class="bi bi-trash-fill"></i>-->
                                        <!--</a>-->
                                    <!--</td>-->
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
        }).buttons().container().appendTo('#tbl_buttons');
    });
</script>
@endPushOnce
