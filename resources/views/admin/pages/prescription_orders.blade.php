@extends('admin.layouts.default')
@section('title', $title)
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
                        <div class="row mb-3 px-4">
                            <div class="col-md-12 mt-3 text-center d-block">
                                <label for="search" class="form-label fw-bold">Search From Table </label>
                                <input type="text" id="search" placeholder="Search here..." class="form-control py-2">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tbl_data" class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Order No.</th>
                                    <th>Items Details</th>
                                    <th>Date-Time</th>
                                    <th>Total Atm.</th>
                                    <th>Payment Status</th>
                                    <th>Order Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders ?? [] as $key => $order)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>
                                        <a href="{{ route('admin.orderDetail', ['id' => base64_encode($order['id'])]) }}" class="text-primary mb-0 font-weight-semibold fw-bold" style="font-size: smaller; display:flex; ">
                                            #{{ $order['id'] }}
                                        </a>
                                    </td>
                                    <td>
                                        @foreach($order['orderdetails'] as $key => $val)
                                        @php
                                        $src = (isset($val['variant'])) ? $val['variant']['image'] : $val['product']['main_image'];
                                        @endphp
                                        <div class="row">
                                            <div class="col-9">
                                                <div class="d-flex align-items-center">
                                                    <div><span class="fw-bold">
                                                            {{ ++$key }}. &nbsp;&nbsp;&nbsp;
                                                        </span></div>
                                                    <img src="{{ asset('storage/'.$src) }}" class="rounded-circle" alt="no image" style="width: 40px; height: 40px" />
                                                    <div class="ms-3">
                                                        <p class="fw-bold mb-1">{!! $val['product_name'] ?? $val['product']['title'] !!} X {{$val['product_qty']}}</p>
                                                        <p class="fw-bold mb-1">{!! $val['variant_details'] ?? '' !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="text-center">
                                                    @if($val['consultation_type'] == 'premd' || $val['consultation_type'] == 'pmd')
                                                    <a href="{{ route('admin.consultationUserView', ['odd_id' => base64_encode($val['id'])]) }}" class="btn btn-link fw-bold small center">
                                                        Consultation
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if($loop->count > 1 && $loop->remaining > 0)
                                        <hr class="mb-2" style="background-color: #e0e0e0; opacity: 1;">
                                        @endif
                                        @endforeach
                                    </td>
                                    @php
                                    $isNewOrder = null;
                                    if($order['status'] == 'Received'):
                                    $createdAt = isset($order['created_at']) ? strtotime($order['created_at']) : null;
                                    $isNewOrder = $createdAt && ($createdAt > strtotime('-3 days'));
                                    endif;
                                    @endphp
                                    <td>
                                        @if($isNewOrder)
                                        <span class="badge bg-primary">New Order</span> <br>
                                        @endif
                                        {{ isset($order['created_at']) ? date('Y-m-d H:i:s', strtotime($order['created_at'])) : '' }}
                                    </td>
                                    <td><span class="fw-bold">£{{$order['total_ammount'] ?? ''}} </span></td>
                                    <td><span class="btn fw-bold rounded-pill btn-success px-4"> {{$order['payment_status'] ?? ''}}</span> </td>
                                    <td><span class="btn  fw-bold btn-primary rounded-pill px-5">{{$order['status'] ?? ''}}</span></td>
                                    <td>
                                        <!-- Reorder button with onclick event -->
                                        <button class="btn btn-primary" onclick="reorder({{ $order['id'] }})">Reorder</button>
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

@pushOnce('scripts')
{{-- <script>
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
            "columnDefs": [{
                "targets": [0, 5, 6, 7],
                "searchable": false
            }]
        });
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
    });
    function reorder(orderId) {
        $.ajax({
            url: '{{ route('cart.reorder') }}',
            type: 'POST',
            data: {
                order_id: orderId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    window.location.href = response.redirect;
                } else {
                    alert('Failed to reorder. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    {{-- }  --}}
    <script> 
    $(function() {
        // Initialize DataTable
        $("#tbl_data").DataTable({
            "paging": true,
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "pageLength": 50,
            "columnDefs": [{
                "targets": [0, 5, 6, 7], // Non-searchable columns
                "searchable": false
            }]
        });
    });

    $(document).ready(function() {
        var tableApi = $('#tbl_data').DataTable();

        // Search functionality for the DataTable
        $('#search').on('input', function() {
            let text = $(this).val();
            tableApi.search(text).draw();
        });
    });

    // Function to handle reorder
    function reorder(orderId) {
    $.ajax({
        url: '{{ route('cart.reorder') }}',
        type: 'POST',
        data: {
            order_id: orderId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                window.location.href = response.redirect;
            } else {
                alert('Failed to reorder. ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            alert('An error occurred. Please try again.');
        }
    });
}

</script>

@endPushOnce