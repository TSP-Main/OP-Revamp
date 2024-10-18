@extends('admin.layouts.default')
@section('title', $title)
@section('content')
<main id="main" class="main">

    <style>
        .modal-backdrop {
            display: none !important; /* Force hide any backdrop */
        }
    </style>

    <div class="pagetitle">
        <h1>
            <a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold">
                <i class="bi bi-arrow-left"></i> Back
            </a> | {{ $title }}
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
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
                                        <a href="{{ route('admin.orderDetail', ['id' => base64_encode($order['id'])]) }}" class="text-primary">#{{ $order['id'] }}</a>
                                    </td>
                                    <td>
                                        @foreach($order['orderdetails'] as $detailKey => $val)
                                            <div>{{ ++$detailKey }}. 
                                                @if(isset($val['product']) && !empty($val['product']['title']))
                                                    {{ $val['product']['title'] }} X <span id="qty-{{ $val['id'] }}">{{ $val['product_qty'] }}</span>
                                                @else
                                                    Product information not available.
                                                @endif
                                            </div>
                                            <div class="col-3">
                                                <div class="text-center">
                                                    @if($val['consultation_type'] == 'premd' || $val['consultation_type'] == 'pmd' || $val['consultation_type'] == 'premd/Reorder')
                                                        <a href="{{ route('admin.consultationView', ['odd_id' => base64_encode($val['id'])]) }}" class="btn btn-link fw-bold small center">
                                                            Consultation
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>{{ isset($order['created_at']) ? date('Y-m-d H:i:s', strtotime($order['created_at'])) : '' }}</td>
                                    <td>£{{ $order['total_ammount'] ?? '' }}</td>
                                    <td><span class="btn btn-success">{{ $order['payment_status'] ?? '' }}</span></td>
                                    <td><span class="btn btn-primary">{{ $order['status'] ?? '' }}</span></td>
                                    <td>
                                        <button class="btn btn-primary" onclick="openReorderModal({{ $order['id'] }}, {{ json_encode($order['orderdetails']) }})">Reorder</button>
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


<!-- Modal for Quantity Update -->
<div class="modal fade" id="reorderModal" tabindex="-1" aria-labelledby="reorderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reorderModalLabel">Update Quantities</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reorderForm">
                    <input type="hidden" id="orderId" name="order_id">
                    <div id="quantityFields"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="background-color: blue; color: white;" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn" style="background-color: green; color: white;" onclick="confirmReorder()">Reorder</button>
            </div>
        </div>
    </div>
</div>

    <div id="iframeContainer" class="vh-100 w-100"></div>

</main>

@pushOnce('scripts')
<script>
    function openReorderModal(orderId, orderDetails) {
        $('#orderId').val(orderId);
        $('#quantityFields').empty();

        orderDetails.forEach(function(detail) {
            const consultationLink = (detail.consultation_type === 'premd' || detail.consultation_type === 'pmd' || detail.consultation_type === 'premd/Reorder') ? 
                `{{ route('admin.consultationFormEdit', ['odd_id' => '__id__']) }}`.replace('__id__', btoa(detail.id)) : '';

            $('#quantityFields').append(`
                <div class="mb-3">
                    <input type="checkbox" id="product-${detail.id}" checked>
                    <label for="product-${detail.id}">${detail.product.title}:</label>
                    <input type="number" class="form-control" name="qty[${detail.id}]" value="${detail.product_qty}" min="1" style="width: 70px;">
                    ${consultationLink ? `<a href="${consultationLink}" class="btn btn-link fw-bold small" style="margin-left: 10px;">Consultation Edit</a>` : ''}
                </div>
            `);
        });

        // Show the modal
        $('#reorderModal').modal('show');
    }


    function confirmReorder() {
        const orderId = $('#orderId').val();
        const formData = $('#reorderForm').serializeArray();
        const quantities = {};
        const selectedProducts = [];

        formData.forEach(field => {
            if (field.name.startsWith('qty')) {
                const productId = field.name.split('[')[1].slice(0, -1);
                const isChecked = $(`#product-${productId}`).is(':checked');
                if (isChecked) {
                    quantities[productId] = field.value; // Only add quantity if checked
                    selectedProducts.push(productId);
                }
            }
        });

        if (selectedProducts.length === 0) {
            alert('Please select at least one product to reorder.');
            return;
        }

        // Disable the button to prevent duplicate submissions
        const reorderButton = $('.modal-footer button:last-child'); // Assuming this is the reorder button
        reorderButton.prop('disabled', true).text('Processing...');

        $.ajax({
            url: '{{ route('cart.reorder') }}',
            type: 'POST',
            data: {
                order_id: orderId,
                quantities: quantities,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#tbl_data').hide(); // Hide the table

                    const iframe = $('<iframe>', {
                        src: response.redirect,
                        frameborder: '0',
                        style: 'border: none; width: 100%; height: 100vh;' 
                    });
                    
                    $('#reorderModal').modal('hide'); // Hide the modal
                    $('#iframeContainer').html(iframe); // Display iframe in the container
                    
                    // Scroll to iframe
                    $('html, body').animate({
                        scrollTop: $('#iframeContainer').offset().top
                    }, 'slow');
                } else {
                    alert('Failed to reorder. ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred. Please try again.');
            },
            complete: function() {
                // Re-enable the button after the request completes
                reorderButton.prop('disabled', false).text('Reorder');
            }
        });
    }
</script>

@endPushOnce
