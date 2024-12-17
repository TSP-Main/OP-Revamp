@extends('admin.layouts.default')
@section('title', 'Discounts')
@section('content')
<!-- main started -->
<main id="main" class="main">
    <style>
        .edit i {
            color: #1AA7C0;
            font-size: 20px;
            margin-right: 10px;
            margin-left: 10px;
            transition: color 0.3s ease;
        }

        .edit i:hover {
            color: #577BBF;
        }

        .delete i {
            color: #E34724;
            font-size: 20px;
            margin-left: 10px;
            transition: color 0.3s ease;
        }

        .delete i:hover {
            color: #F14C3B;
        }

        .card-body {
            background-color: #f8f9fa;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #E3F2FD; /* Light Blue */
        }

        .table tbody tr:nth-child(even) {
            background-color: #B3E5FC; /* Lighter Blue */
        }

        .badge {
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 12px;
        }

        .badge.bg-success {
            background-color: #28a745;
        }

        .badge.bg-danger {
            background-color: #dc3545;
        }

        .table .actions a {
            cursor: pointer;
            margin: 0 5px;
        }

        .table-striped tbody tr:hover {
            background-color: #1AA7C0;
            color: white;
        }

        .btn-add-discount {
            background-color: #1AA7C0;
            border: 1px solid #1AA7C0;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-add-discount:hover {
            background-color: #577BBF;
            transition: background-color 0.3s ease;
        }
    </style>

    <div class="pagetitle">
        <h1>
            <a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | Discounts
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Discounts</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table id="tbl_discounts" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Discount Type</th>
                                    <th>Value</th>
                                    <th>Selection Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Usage</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($discounts as $key => $discount)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $discount->code }}</td>
                                    <td>
                                        @if($discount->discount_type === 'free_shipping')
                                            <span class="badge bg-success">Free Shipping</span>
                                        @elseif($discount->discount_type === 'fixed_amount')
                                            <span class="badge bg-primary">Fixed Amount</span>
                                        @elseif($discount->discount_type === 'percentage')
                                            <span class="badge bg-secondary">Percentage</span>
                                        @else
                                            <span class="badge bg-danger">{{ ucfirst($discount->discount_type) }}</span>
                                        @endif
                                    </td>
                                    
                                    <td>{{ $discount->value ?? 'Free Ship' }}</td>
                                    <td>{{ ucfirst($discount->selection_type) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($discount->start_date)->format('d M, Y') }}</td>
                                    <td>{{ $discount->end_date ? \Carbon\Carbon::parse($discount->end_date)->format('d M, Y') : 'N/A' }}</td>
                                    <td>{{$discount->max_usage}}</td>
                                    <td>
                                        <span class="badge {{ $discount->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $discount->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;" >
                                        <a class="edit" style="cursor: pointer;" title="Edit" data-id="{{$discount['id']}}" data-toggle="tooltip">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="delete" style="cursor: pointer;" title="Delete" data-id="{{$discount['id']}}" data-toggle="tooltip">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Form to handle both edit and delete actions -->
<form id="edit_form" action="{{ route('admin.editDiscount') }}" method="GET">
    @csrf
    <input id="edit_form_id_input" type="hidden" name="discount" value="">
</form>

{{-- <form id="delete_form" action="{{ route('admin.deleteDiscount') }}" method="post">
    @csrf
    @method('DELETE')
    <input id="delete_form_id_input" type="hidden" name="discount_id" value="">
</form> --}}

@stop

@pushOnce('scripts')
<script>
    $(function() {
        $("#tbl_discounts").DataTable({
            "paging": true,
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": false,
            "ordering": true,
            "info": true,
        });
    });

    $(document).ready(function () {
    // Handle the edit button click
    $('.edit').click(function () {
        var id = $(this).data('id');
        var url = '{{ route("admin.editDiscount", ":id") }}';
        url = url.replace(':id', id); // Replace :id placeholder with the actual discount ID
        window.location.href = url; // Redirect to the edit page
    });



        // Handle the delete button click
        $('.delete').click(function () {
            var id = $(this).data('id');
            // Handle delete logic
        });
    });
</script>
@endpushOnce
