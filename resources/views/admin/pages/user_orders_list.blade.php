@extends('admin.layouts.default')
@section('title', 'Orders List')
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
        <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | {{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">{{ $title }}</li>
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
                        <table id="tbl_data" class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Order No.</th>
                                    <th>Order History</th>
                                    <th>Date-Time</th>
                                    <th>Customer Name</th>
                                    <th>D.O.B</th>
                                    <th>Address</th>
                                    @if($user->role == user_roles('1'))
                                    <th>Total Atm.</th>
                                    @endif
                                    <th>View Questionnaire </th>
                                    <th>Payment Status</th>
                                    <th>Order Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach($orders ?? [] as $key => $val)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                <td>
                                    <a href="{{ route('admin.orderDetail',['id'=> $val['id']]) }}" class="text-primary mb-0 font-weight-semibold fw-bold" style="font-size: smaller; display:flex; ">
                                        #3434{{ $val['id'] }}
                                    </a>
                                </td>
                                <td>
                                    @if(isset($order_history[$val['email']]))
                                    <span class=" px-5 fw-bold">{{ $order_history[$val['email']]['total_orders'] ?? 0}} </span>
                                    @endif
                                </td>
                                <td>{{ isset($val['created_at']) ? date('Y-m-d H:i:s', strtotime($val['created_at'])) : '' }}</td>
                                <td>{{ $val['user']['name'] ?? '' }}</td>
                                <td>{{ isset($val['user']['dob']) ? date('M d, Y', strtotime($val['user']['dob'])) : '' }}</td>
                                <td>{{$val['user']['address'] ?? ''}}</td>
                                @if($user->role == user_roles('1'))
                                <td>£{{ number_format((float)str_replace(',', '', $val['total_ammount']), 2) }}</td>
                                @endif
                                <td>
                                    <button class="btn btn-primary rounded-pill">Donwload File</button>
                                </td>
                                <td>
                                    {{$val['payment_status'] ?? ''}}
                                </td>
                                <td>{{$val['status'] ?? ''}}</td>
                                <td> <a class="edit" title="Edit" data-toggle="tooltip">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a class="delete" title="Delete" data-toggle="tooltip">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </td>
                                </tr>
                                @endforeach --}}
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
        });
    });
</script>
@endPushOnce