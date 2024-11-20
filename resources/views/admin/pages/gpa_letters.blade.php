@extends('admin.layouts.default')
@section('title', 'GP Letters')
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
        <h1> <a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> |GP Letters</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">GP Letters</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header mt-3" id="tbl_buttons" style="border: 0 !important; border-color: transparent !important;"></div>
                    <div class="row mb-3 px-4">

                        <div class="col-md-12 mt-3 text-center d-block">
                            <label for="search" class="form-label fw-bold">Search From Table </label>
                            <input type="text" id="search" placeholder="Search here..." class="form-control py-2">
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tbl_data" class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Order No.</th>
                                    <th>Date-Time</th>
                                    <th>Customer Name</th>
                                    <th>DOB</th>
                                    <th>General Question</th>
                                    <th>GP Email</th>
                                    <th>Order Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders ?? [] as $key => $val)
                                <tr>
                                    <td>
                                        <a target="_blank" href="{{ route('admin.orderDetail',['id'=> base64_encode($val['id'])]) }}" class="text-primary mb-0 font-weight-semibold fw-bold" style="font-size: smaller; display:flex; ">
                                            #{{ $val['id'] }}
                                        </a>
                                    </td>
                                    <td>{{date_time_uk($val['created_at'])}}
                                    </td>
                                    <td>
                                        {{-- {{ $val['shipingdetails']['firstName'] . ' ' . $val['shipingdetails']['lastName'] ?? $val['user']['name'] }} --}}
                                        @if (isset($val['shipping_details']) && $val['shipping_details'])
                                        {{ $val['shipping_details']['firstName'] ?? '' }}
                                        {{ $val['shipping_details']['lastName'] ?? '' }}
                                        @elseif(isset($val['user']) && $val['user'])
                                        {{ $val['user']['name'] ?? '' }}
                                        @else
                                        N/A
                                        @endif

                                    </td>
                                    <td>{{ $val['user']['profile']['date_of_birth'] ?? '' }}</td>
                                    @php
                                        $genericConsultation = isset($val['orderdetails'][0]['generic_consultation']) 
                                            ? json_decode($val['orderdetails'][0]['generic_consultation'], true) 
                                            : [];
                                    @endphp
                                    <td>{{ $genericConsultation[4] ?? '' }}</td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <input class="form-control" type="email" id="gpa_email_{{$val['id']}}" value="">
                                    </td>
                                    <td>
                                        <span class="btn fw-bold rounded-pill 
                                            {{ $val['order_type'] == 'premd' ? 'btn-primary' : 
                                                ($val['order_type'] == 'pmd' ? 'btn-warning' : 
                                                ($val['order_type'] == 'premd/Reorder' ? 'btn-info' : 'btn-success')) }}">
                                            {{ $val['order_type'] == 'premd' ? 'POM' : 
                                                ($val['order_type'] == 'pmd' ? 'P.Med' : 
                                                ($val['order_type'] == 'premd/Reorder' ? 'Reorder' : 'O.T.C')) }}
                                        </span>
                                    </td>
                                    <th>
                                        <button type="button" data-id="{{$val['id']}}" class="btn btn-small  bg-secondary  rounded-pill text-center update_gpa">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" data-id="{{$val['id']}}" class="btn btn-small  bg-success rounded-pill text-center send_gpa">
                                            <i class="bi bi-send"></i>
                                        </button>
                                        <button type="button" data-id="{{$val['id']}}" class="btn btn-small bg-primary  rounded-pill text-center download_gpa">
                                            <i class="bi bi-download"></i>
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
<form id="download_form" action="{{route('pdf.createGpaLetters')}}" method="post">
    <input id="pdf_form_id_input" type="hidden" value="" name="id">
    <input type="hidden" name="view_name" value="gpa_letters" required>
</form>

<form id="send_form" action="{{route('pdf.sendGpaLetters')}}" method="post">
    <input id="send_pdf_form_id_input" type="hidden" value="" name="id">
    <input id="send_pdf_form_email_input" type="hidden" value="" name="email">
    <input type="hidden" name="view_name" value="gpa_letters" required>
</form>

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
                    text: 'Download PDF ',
                    className: 'btn-blue',
                },
                {
                    extend: 'print',
                    text: 'Print Out',
                    className: 'btn-blue',
                }
            ]
        }).buttons().container().appendTo('#tbl_buttons');
    });


    $(document).ready(function() {
        var tableApi = $('#tbl_data').DataTable();

        $('#search').on('input', function() {
            let text = $(this).val();
            if (text === '') {
                tableApi.search('').draw();
            } else {
                tableApi.search(text).draw();
            }
        });

        $(document).on('click', '.download_gpa', function() {
            var id = $(this).data('id');
            $('#pdf_form_id_input').val(id);
            $('#download_form').submit();
        });

        $(document).on('click', '.send_gpa', function() {
            var id = $(this).data('id');
            var $email = $('#gpa_email_'+id).val();
            $('#send_pdf_form_id_input').val(id);
            $('#send_pdf_form_email_input').val($email);
            $('#send_form').submit();
        });
    });
</script>
@endPushOnce
