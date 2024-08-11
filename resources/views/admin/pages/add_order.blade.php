@extends('admin.layouts.default')
@section('title', 'Create Order')
@section('content')
<style>
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

    .hide {
        display: none;
    }
</style>
<!-- main stated -->
<main id="main" class="main">

    <div class="pagetitle">
        <h1<a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | Create Order</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Create Order</li>
                </ol>
            </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <!-- Multi Columns Form -->
                        <form class="row g-3 mt-3 needs-validation" method="post" action="{{ route('admin.storeOder') }}" novalidate>
                            @csrf
                            <input type="hidden" name="id" id="order_id" value="{{ $order['id'] ?? '' }}">
                            <label for="product_id" class="form-label fw-bold">Select Product: </label>
                            <div class="row">
                                <div class="col-11  d-block mb-5">
                                    <select id="product_id" name="product_id" class="form-select select2" data-placeholder="choose product ...">
                                        <option value=""></option>
                                        @foreach ($products ?? [] as $key => $product)
                                        <option {{ isset($order['product_id']) && $product['id'] == $order['product_id'] ? 'selected' : '' }} {{ $product['id'] == old('product_id') ? 'selected' : '' }} value="{{ $product['id'] }}" data-img="{{ asset('storage/' . $product['main_image']) }}">
                                            {{ $product['title'] ?? '' }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select product!</div>
                                    @error('product_id')
                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-1 d-block text-center">
                                    <button type="button" id="add_product" class="btn btn-success  fw-semibold" style="background-color: green;">
                                        + Add
                                    </button>
                                </div>
                            </div>
                            <!-- varainats dynamic -->
                            <div class="col-md-12 variants d-block mb-5"></div>

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header text-center " style="background:#88888870;">
                                        <label class=" fw-bold text-dark m-0">Products Details</label>
                                    </div>
                                    <div class="card-body p-0 ">
                                        <table id="tbl_data" class="table table-bordered table-striped mb-0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th style="vertical-align: middle; text-align: center;">#</th>
                                                    <th style="vertical-align: middle; padding:10px 20px;">Details</th>
                                                    <th style="vertical-align: middle; text-align: center;">Price</th>
                                                    <th style="vertical-align: middle; text-align: center;">Quantity
                                                    </th>
                                                    <th style="vertical-align: middle; text-align: center;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="card">
                                    <div class="card-header text-center " style="background:#88888870;">
                                        <label class=" fw-bold text-dark m-0">Payment Details</label>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="col-12 px-4 border-1 mt-3 mb-4 ">
                                            <div class="row ">
                                                <div class="col-4 ">
                                                    <lable class="fw-semibold large text-left ">Total Items: </lable>
                                                </div>
                                                <div class="col-4 text-center ">
                                                    <span id="total_items"> 0 </span> items
                                                </div>
                                                <div class="col-4 text-center ">
                                                    <span id="total_price">0.00</span>£
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-4">
                                                    <lable class="fw-semibold large text-left ">Shiping Cost: </lable>
                                                </div>
                                                <div class="col-4 text-center"> --------</div>
                                                <div class="col-4 text-center">
                                                    <span id="shiping_cost">0.00</span>£
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-4">
                                                    <lable class="fw-semibold large text-left">Add Discount:</lable>
                                                </div>
                                                <div class="col-4 text-center d-flex justify-content-center">
                                                    <div style="width: 100%;">
                                                        <input type="number" placeholder="0 ٪" max="100" min="0.01" step="0.01" style="text-align: center;" name="discount_percent" id="discount_percent" class="form-control mx-auto w-50">
                                                    </div>
                                                </div>
                                                <div class="col-4 text-center">
                                                    <span id="discount_amount">0.00</span>£
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-4">
                                                    <lable class="fw-bold large text-left">Total Ammount:</lable>
                                                </div>
                                                <div class="col-4 text-center">--------</div>
                                                <div class="col-4 text-center">
                                                    <span id="total_amount">0.00</span>£
                                                </div>
                                                <input type="hidden" name="total_amount" id="total_amount_input" value="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 d-block">
                                <label for="user_id" class="form-label fw-bold">Select User: </label>
                                <select id="user_id" name="user_id" class="form-select select2" data-placeholder="choose Users ...">
                                    <option value=""></option>
                                    @foreach ($users ?? [] as $key => $user)
                                    <option {{ isset($order['user_id']) && $user['id'] == $order['user_id'] ? 'selected' : '' }} {{ $user['id'] == old('user_id') ? 'selected' : '' }} value="{{ $user['id'] }}">
                                        {{ $user['name'] . ' (' . $user['email'] . ') ' ?? '' }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select user!</div>
                                @error('user_id')
                                <div class="alert-danger text-danger ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <div class="card">
                                    <div class="card-header text-center " style="background:#88888870;">
                                        <label class=" fw-bold text-dark m-0">Billing Details</label>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="col-12 px-4 border-1 mt-3 mb-4">
                                            <h5 class="fw-bold large" style="text-decoration: underline !important;">
                                                Personal Information: </h5>
                                            <div class="row">
                                                <div class="col-md-6 mt-2">
                                                    <label for="firstName" class="form-label ">First Name: </label>
                                                    <input type="text" name="firstName" value="{{ $order['firstName'] ?? old('firstName') }}" class="form-control" id="firstName" required>
                                                    <div class="invalid-feedback">Please enter first Name!</div>
                                                    @error('firstName')
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="lastName" class="form-label ">Last Name: </label>
                                                    <input type="text" name="lastName" value="{{ $order['lastName'] ?? old('lastName') }}" class="form-control" id="lastName" required>
                                                    <div class="invalid-feedback">Please enter Last Name!</div>
                                                    @error('lastName')
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="email" class="form-label ">Email: </label>
                                                    <input type="email" name="email" value="{{ $order['email'] ?? old('email') }}" class="form-control" id="email" required>
                                                    <div class="invalid-feedback">Please enter Email!</div>
                                                    @error('email')
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="phone" class="form-label ">Phone: </label>
                                                    <input type="phone" name="phone" value="{{ $order['phone'] ?? old('phone') }}" class="form-control" id="phone" required>
                                                    <div class="invalid-feedback">Please enter Phone!</div>
                                                    @error('phone')
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <h5 class="fw-bold large mt-3" style="text-decoration: underline !important;">Address Information:
                                            </h5>
                                            <div class="row">
                                                <div class="col-md-6 mt-2">
                                                    <label for="address" class="form-label ">Address: </label>
                                                    <input type="address" name="address" value="{{ $order['address'] ?? old('address') }}" class="form-control" id="address" required>
                                                    <div class="invalid-feedback">Please enter Address!</div>
                                                    @error('address')
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="address2" class="form-label ">Town (optional)</label>
                                                    <input type="address2" name="address2" value="{{ $order['address2'] ?? old('address2') }}" class="form-control" id="address2">
                                                    <div class="invalid-feedback">Please enter Apartment!</div>
                                                    @error('address2')
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <label for="city" class="form-label ">City: </label>
                                                    <input type="city" name="city" value="{{ $order['city'] ?? old('city') }}" class="form-control" id="city" required>
                                                    <div class="invalid-feedback">Please enter city!</div>
                                                    @error('city')
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class=" col-md-6 mt-2">
                                                    <label for="zip_code" class="form-label ">Postal Code: </label>
                                                    <input type="zip_code" name="zip_code" value="{{ $order['zip_code'] ?? old('zip_code') }}" class="form-control" id="zip_code" required>
                                                    <div class="invalid-feedback">Please enter zip_code!</div>
                                                    @error('zip_code')
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <h5 class="fw-bold large mt-3" style="text-decoration: underline !important;">Shipping Method:</h5>
                                            <div class="row">
                                                <div class="col-md-12 mt-2 d-flex justify-content-center gap-5">
                                                    <div class="form-check">
                                                        <div class="custom-control">
                                                            <input class="form-check-input" type="radio" name="shiping_cost" id="fast_delivery" value="3.95" data-ship="3.95" checked="" required="">
                                                            <label class="form-check-label" for="fast_delivery">Royal
                                                                Mail Tracked 48
                                                                <span class="float-right">£3.95</span>
                                                                <div class="ml-4 mb-2 small">(3-5 working days)</div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-check">
                                                        <div class="custom-control">
                                                            <input class="form-check-input" type="radio" name="shiping_cost" id="express_delivery" value="4.95" data-ship="4.95" required="">
                                                            <label class="form-check-label" for="express_delivery">Royal Mail Tracked 24
                                                                <span class="float-right">£4.95</span>
                                                                <div class="ml-4 mb-2 small">(1-2 working days)</div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @error('shipping_method')
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-3 ">
                                                <label for="note" class="form-label fw-bold">Order Notes:
                                                    <small>(Optional)</small></label>
                                                <textarea name="note" class="form-control" cols="10" rows="3" id="note"> {!! $order['note'] ?? old('note') !!} </textarea>
                                                @error('note')
                                                <div class="alert-danger text-danger ">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4 mb-3 d-flex justify-content-center ">
                                <button type="reset" class="btn btn-secondary bg-secondary px-5 py-2 mx-2 fw-bold">Reset</button>
                                <button type="submit" class="btn btn-success px-5 py-2 btn_theme fw-bold">Generate
                                    Payement Link</button>
                            </div>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main>
<!-- End #main -->
@stop

@pushOnce('scripts')
<script>
    $(document).ready(function() {
        var $products = @json($products);
        var $variants = @json($variants);
        var $users = @json($users);
        var total_items = 0;
        var total_price = 0;
        $(document).on('click', '#add_product', function() {
            var productHtml = '';
            var variHtml = 'No';
            var proId = $('#product_id').val();
            if (proId) {
                if ($products[proId]) {

                    let product = $products[proId];
                    let imageUrl = "{{ asset('storage') }}/" + product.main_image;
                    if ($variants[proId]) {
                        $.each($variants[proId], function(index, variant) {
                            if (variant.id == $('#variant_id').val()) {
                                variHtml = variant.slug +
                                    `<input type="hidden" name="pro_${product.id}_vari" value="${variant.id}" />`;
                            }
                        });
                    }
                    productHtml = `
                                <tr>
                                    <th style="vertical-align: middle; text-align: center;">${product.id}</th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="${imageUrl}" class="rounded-circle" alt="no image" style="width: 45px; height: 45px" />
                                            <div class="ms-3">
                                                <label class="fw-semibold mb-1">${product.title}</label>
                                                <p class="text-muted mb-0"><b>Variant:</b> ${variHtml} </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <span class="fw-normal mb-1" id="price_id_${product.id}">${product.price} </span>£
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <div style="display: inline-block; width: 100%;">
                                            <input type="number" name="pro_${product.id}_qty" value="1" data-price_id="${product.id}"  data-price_qty="1" class="form-control py-2 text-center w-50 fw-semibold product_qty" id="product_qty_${product.id}" required style="margin: 0 auto;">
                                            <div class="invalid-feedback">Please enter Quantity!</div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <a class="delete" style="cursor: pointer;" title="Delete" data-row_id="${product.id}" data-toggle="tooltip">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>`;
                    $('#tbl_data tbody').prepend(productHtml);
                    $('#product_id').val(null).trigger('change');
                    $('.variants').html('');
                    total_items++;
                    calculate_payment(product.price);
                } else {
                    alert('Selected Product does not exist.')
                }
            } else {
                alert('Please Select Product first.')
            }
        });

        $(document).on('click', '.delete', function() {
            var row_id = $(this).data('row_id');
            $(this).closest('tr').fadeOut('slow', function() {
                var product_qty = parseFloat($('#product_qty_' + row_id).val());
                if (product_qty) {
                    let product_price = $('#price_id_' + row_id).text();
                    total_price -= parseFloat(product_price) * product_qty;
                    let price = 0;
                    total_items--;
                    calculate_payment(price);
                }
                $(this).remove();
            });
        });

        $(document).on('change', '#product_id', function() {
            var productId = $(this).val();
            if ($products[productId]) {
                if ($variants[productId]) {
                    var variantHtml =
                        '<label for="variant_id" class="form-label fw-bold">Choose Variant</label>' +
                        '<select id="variant_id" name="variant_id" class="form-select select2" required>';

                    $.each($variants[productId], function(index, variant) {
                        var img_src = $('#product_id option:selected').data('img');
                        if (variant.image) {
                            img_src = "{{ asset('storage') }}/" + variant.image;
                        }
                        variantHtml += '<option value="' + variant.id + '" data-img="' +
                            img_src + '">' + variant.slug + '</option>';
                    });

                    variantHtml += '</select>' +
                        '<div class="invalid-feedback">Please enter variant!</div>';
                    $('.variants').html(variantHtml);

                    // Initialize Select2 with custom template
                    $('#variant_id').select2({
                        templateResult: imageState,
                        templateSelection: imageState,
                        width: '100%'
                    });
                } else {
                    $('.variants').html('');
                }
            }
        });

        $(document).on('change', '#user_id', function() {
            var userId = $(this).val();
            if ($users[userId]) {
                let user = $users[userId];
                $('#firstName').val(user.name);
                $('#email').val(user.email);
                $('#phone').val(user.phone);
                $('#address').val(user.address);
                $('#address2').val(user.apartment);
                $('#city').val(user.city);
                $('#zip_code').val(user.zip_code);
            } else {
                alert('technical error');
            }
        });


        $('#discount_percent').on('input', function() {
            var discountPercent = parseFloat($(this).val());
            if (discountPercent < 0) {
                $(this).val('0.01');
            } else if (discountPercent > 100) {
                $(this).val('100');
            }
            $(this).removeClass('is-invalid');
            update_d_payment();
        });

        $(document).on('input', '.product_qty', function() {
            var product_qty = parseFloat($(this).val());
            if (product_qty) {
                let row_id = $(this).data('price_id');
                let price_qty = $(this).data('price_qty');
                let product_price = $('#price_id_' + row_id).text();
                total_price -= parseFloat(product_price) * price_qty;
                let price = parseFloat(product_price) * product_qty;
                calculate_payment(price);
                $(this).data('price_qty', product_qty);
            }
        });

        $(document).on('blur', '.product_qty', function() {
            var product_qty = parseFloat($(this).val());
            if (isNaN(product_qty) || product_qty <= 0) {
                $(this).val(1).trigger('input');
            }
        });

        const update_d_payment = () => {
            let price = $('#total_price').text();
            var d_amount = 0.00;
            if (typeof price === 'string') {
                price = parseFloat(price);
            }
            // Default price to 0 if it's not a valid number
            if (typeof price !== 'number' || isNaN(price)) {
                price = 0;
            }

            total_price = price;

            let shippingCost = $('input[name="shiping_cost"]:checked').val();
            var total_amount = parseFloat(total_price) + parseFloat(shippingCost);
            var discountPercent = $('#discount_percent').val();
            if (discountPercent) {
                discountPercent = (typeof discountPercent === 'undefined' || isNaN(discountPercent)) ? 0 :
                    parseFloat(discountPercent);
                let discountDecimal = discountPercent / 100;
                let discountAmount = parseFloat(total_price) * discountDecimal;
                total_amount = total_amount - parseFloat(discountAmount);
                d_amount = discountAmount.toFixed(2);
            }
            var t_price = total_price.toFixed(2);
            var t_amount = total_amount.toFixed(2);

            $('#total_items').text(total_items);
            $('#total_price').text(t_price);
            $('#shiping_cost').text(shippingCost);
            $('#discount_amount').text(d_amount);
            $('#total_amount').text(t_amount);

        }

        function imageState(state) {
            if (!state.id) {
                return state.text;
            }
            var imgSrc = $(state.element).data('img');
            if (imgSrc) {
                var $state = $(
                    '<span><img src="' + imgSrc +
                    '" class="rounded-circle" style="width: 35px; height: 35px; margin-right: 8px;" />' +
                    state.text + '</span>'
                );
                return $state;
            } else {
                return state.text;
            }
        }

        const calculate_payment = (price) => {
            var d_amount = 0.00;
            if (typeof price === 'string') {
                price = parseFloat(price);
            }
            // Default price to 0 if it's not a valid number
            if (typeof price !== 'number' || isNaN(price)) {
                price = 0;
            }
            total_price += price;

            let shippingCost = $('input[name="shiping_cost"]:checked').val();
            var total_amount = parseFloat(total_price) + parseFloat(shippingCost);
            var discountPercent = $('#discount_percent').val();
            if (discountPercent) {
                discountPercent = (typeof discountPercent === 'undefined' || isNaN(discountPercent)) ? 0 :
                    parseFloat(discountPercent);
                let discountDecimal = discountPercent / 100;
                let discountAmount = parseFloat(total_price) * discountDecimal;
                total_amount = total_amount - parseFloat(discountAmount);
                d_amount = discountAmount.toFixed(2);
            }
            var t_price = total_price.toFixed(2);
            var t_amount = total_amount.toFixed(2);

            $('#total_items').text(total_items);
            $('#total_price').text(t_price);
            $('#shiping_cost').text(shippingCost);
            $('#discount_amount').text(d_amount);
            $('#total_amount').text(t_amount);
            document.getElementById('total_amount_input').value = t_amount;

        }
        // Assuming you have JavaScript that calculates total_amount dynamically


        // $.ajax({
        //     url: $(this).attr('action'),
        //     type: $(this).attr('method'),
        //     data: formData,
        //     processData: false,
        //     contentType: false,
        //     success: function(response) {
        //         if (response.status === 'success') {
        //             window.location.href = "{{ route('admin.prodcuts') }}";
        //         } else if (response.status === 'error') {

        //             console.log(response.message);
        //             $('.error-label').remove();

        //             $.each(response.message, function(field, errorMessages) {
        //                 var inputField = $('input[name="' + field + '"]');

        //                 $.each(errorMessages, function(index, errorMessage) {
        //                     var errorLabel = $('<label class="error-label text-danger">* ' + errorMessage + '</label>');
        //                     inputField.addClass('error');
        //                     inputField.after(errorLabel);
        //                 });
        //             });
        //         }

        //     },
        //     error: function(error) {
        //         alert('technical error occur')
        //     }
        // });
    });

    function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        var imgSrc = $(state.element).data('img');
        if (imgSrc) {
            var $state = $(
                '<span><img src="' + imgSrc +
                '" class="rounded-circle" style="width: 35px; height: 35px; margin-right: 8px;" />' + state.text +
                '</span>'
            );
            return $state;
        } else {
            return state.text;
        }
    }

    $('#product_id').select2({
        templateResult: formatState,
        templateSelection: formatState,
        width: '100%'
    });
</script>
@endPushOnce