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
                                                {{-- Display the product title --}}
                                                {{ $val['product']['title'] }} X <span id="qty-{{ $val['id'] }}">{{ $val['product_qty'] }}</span>
                                        
                                                {{-- Display the variant title if it exists --}}
                                                @if(isset($val['variant_id']))
                                                    @php
                                                        // Find the variant based on variant_id
                                                        $variant = collect($val['product']['variants'])->firstWhere('id', $val['variant_id']);
                                                    @endphp
                                                    {{-- Check if a variant is found and display the variant title --}}
                                                    @if($variant)
                                                        <br><span class="variant-title"><strong>Variant:</strong> {{ $variant['title'] }}</span>
                                                        <br><span class="variant-value"><strong>Variant Value:</strong> {{ $variant['value'] }}</span>
                                                    @else
                                                        <br><span class="variant-title">Variant: Not Available</span>
                                                    @endif
                                                @endif
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
                <h5 class="modal-title" id="reorderModalLabel">Update Your Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reorderForm">
                    <input type="hidden" id="orderId" name="order_id">
                    <div id="quantityFields"></div>
                    <div id="fileUploadAlert" class="alert alert-danger d-none" role="alert">
                        Please fill the required consultation questions before reordering. <strong>Failure to do so may result in order rejection.</strong>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="background-color: blue; color: white;" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn" style="color: white;" id="reorderBtn" onclick="confirmReorder()">Reorder</button>
            </div>
        </div>
    </div>
</div>




    <div id="iframeContainer" class="vh-100 w-100"></div>

</main>

@pushOnce('scripts')
<script>
  let formUpdated = false; // Flag to track if the form has been updated

function openReorderModal(orderId, orderDetails) {
    $('#orderId').val(orderId);
    $('#quantityFields').empty(); // Clear previous quantity fields
    $('#fileUploadAlert').addClass('d-none'); // Hide the alert initially

    let requiresFileUpload = false;
    let showAlert = true;  // Default behavior is to show the alert

    @if(session('modal_open') && session('order_id'))
        let modalOpenOrderId = '{{ session('order_id') }}';
        if (modalOpenOrderId == orderId) {
            showAlert = false;
            // If session indicates form status is 'updated', change button color and enable it
            if ('{{ session('form_status') }}' === 'updated') {
                formUpdated = true; // Set formUpdated to true based on session
            }
        }
    @endif

    let childCategory19Products = [];

    orderDetails.forEach(function(detail) {
        // Check if the product belongs to child category 19
        if (detail.product.child_category === 19) {
            requiresFileUpload = true; // Set flag if file upload is required
            childCategory19Products.push(detail.id); // Add product ID to list for category 19
        }

        const consultationLink = (detail.consultation_type === 'premd' || detail.consultation_type === 'pmd' || detail.consultation_type === 'premd/Reorder') ? 
            `{{ route('admin.consultationFormEdit', ['odd_id' => '__id__']) }}`.replace('__id__', btoa(detail.id)) : '';

        let variantSelect = '';
        let selectedVariantId = detail.variant_id;  // Track the selected variant ID
        let selectedVariantName = ''; // To store the name of the selected variant

        if (detail.product.variants.length > 0) {
            variantSelect = `<select class="form-control" id="variant-${detail.id}">`;
            variantSelect = `<label for="variant-${detail.id}"><strong>Select Variant</strong></label>` + variantSelect;

            detail.product.variants.forEach(function(variant) {
                let selectedAttribute = (variant.id == selectedVariantId) ? 'selected' : '';
                variantSelect += `<option value="${variant.id}" data-price="${variant.price}" ${selectedAttribute}>${variant.value} - £${variant.price}</option>`;
                if (variant.id == selectedVariantId) {
                    selectedVariantName = variant.value; 
                }
            });
            variantSelect += `</select>`;
        }

        $('#quantityFields').append(`
            <input type="checkbox" id="product-${detail.id}" checked style="transform: scale(1.5); margin-bottom: 7px;">
            <div class="mb-3">
                <div style="background-color: #C0D1EC; padding: 10px; border-radius: 5px;">
                    <label for="product-${detail.id}">
                        <p style="color: #4A4A4A; font-size: 20px;">${detail.product.title}</p>
                        ${selectedVariantName ? `<strong style="color: #4A4A4A;">Previously Selected Variant:</strong> ${selectedVariantName}` : ''}
                    </label>
                </div>
                <br>
                ${variantSelect}
                <div class="d-flex align-items-center mt-3">
                    <label for="qty-${detail.id}" style="font-size: 16px; margin-right: 10px;">Quantity:</label>
                    <input type="number" class="form-control" name="qty[${detail.id}]" value="${detail.product_qty}" min="1" id="qty-${detail.id}" style="width: 70px;">
                </div>
                <label>Counsultancy:</label>
                ${consultationLink ? `<button onclick="window.location.href='${consultationLink}'; return false;" class="btn btn-danger fw-bold small" style="margin-left: 10px;">Update</button>` : ''}
            </div>
        `);
    });

    // If any product requires file upload (category 19), show the warning alert
    if (requiresFileUpload && showAlert) {
        $('#fileUploadAlert').removeClass('d-none'); // Show the alert
    }

    // Update the reorder button's state based on the session data
    updateReorderButtonState(childCategory19Products);

    // Show the modal with Bootstrap's modal API
    const reorderModal = new bootstrap.Modal(document.getElementById('reorderModal'));
    reorderModal.show();
}

function updateReorderButtonState(childCategory19Products) {
    const reorderButton = $('#reorderBtn');

    // Disable the button if any product belongs to child category 19 and the form hasn't been updated
    const isAnyCategory19ProductChecked = childCategory19Products.some(productId => $(`#product-${productId}`).is(':checked'));

    if (isAnyCategory19ProductChecked && !formUpdated) {
        reorderButton.css('background-color', 'red').prop('disabled', true); // Disable button for category 19 products
    } else {
        reorderButton.css('background-color', 'green').prop('disabled', false); // Enable button when form is updated
    }
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
                quantities[productId] = {
                    qty: field.value,
                    variant_id: $(`#variant-${productId}`).val() // Get the selected variant ID
                };
                selectedProducts.push(productId);
            }
        }
    });

    if (selectedProducts.length === 0) {
        alert('Please select at least one product to reorder.');
        return;
    }

    // Disable the button to prevent duplicate submissions
    const reorderButton = $('.modal-footer button:last-child');
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

