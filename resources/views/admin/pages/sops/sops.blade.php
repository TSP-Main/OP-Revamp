@extends('admin.layouts.default')
@section('title', 'SOPs')
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
        <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | SOP's Listing</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">SOP's Listing</li>
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
                        <table id="tbl_data" class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="vertical-align: middle; text-align: center;">#</th>
                                    <th style="vertical-align: middle; text-align: center;">Name</th>
                                    <th style="vertical-align: middle; text-align: center;">File For</th>
                                    <th style="vertical-align: middle; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sops ?? [] as $key => $sop)
                                <tr>
                                    <th style="vertical-align: middle; text-align: center;">{{ ++$key ?? '' }}</th>
                                    <td style="vertical-align: middle; text-align: center;">{{ $sop['name'] ?? '' }}</td>
                                    <td style="vertical-align: middle; text-align: center; font-weight: bold;">{{ $sop['file_for'] ?? '' }}</td>

                                    <td style="vertical-align: middle; text-align: center;">
                                        <a href="{{ asset('storage/'.$sop['file']) }}" target="_blank" class="preview" style="cursor: pointer; font-size:larger;" title="Preview" data-id="2752" data-toggle="tooltip">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if(isset($user->role) && $user->role == user_roles('1'))
                                        <a class="fw-bold btn-link mx-2" href="{{ asset('storage/'.$sop['file']) }}" download>
                                            <i class="bi bi-cloud-download"></i>
                                        </a>
                                        <a href="{{ route('admin.addSOP', ['id' => base64_encode($sop['id'])]) }}" class="edit" style="cursor: pointer;" title="Edit" data-id="" data-toggle="tooltip">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="{{ route('admin.deleteSOP', ['id' => base64_encode($sop['id'])]) }}" class="delete" style="cursor: pointer;" title="Delete" data-id="{{ base64_encode($sop['id']) }}" data-toggle="tooltip">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                        @endif
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



@stop