@extends('web.layouts.default')
@section('title', 'Checkout')
@section('content')


<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image " data-bs-bg="img/bg/14.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title">Checkout</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span>
                                    Home</a></li>
                            <li>Checkout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- WISHLIST AREA START -->
<div class="ltn__checkout-area mb-150">
    <div class="container">
        <form id="checkoutForm" action="{{ route('payment') }}" method="post">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__checkout-inner">
                        <div class="ltn__checkout-single-content">
                            <h4 class="title-2">Billing Details</h4>
                            <!-- <p><label class="input-info-save mb-0"><input type="checkbox" name="agree"> use different billing address?</label></p> -->

                            <div class="ltn__checkout-single-content-info">
                                @csrf
                                @if (!empty(Cart::content()))
                                @foreach (Cart::content() as $item)
                                <input type="hidden" name="order_details[product_id][]" value="{{ $item->id }}">
                                <input type="hidden" name="order_details[product_name][]" value="{{ $item->name }}">
                                <input type="hidden" name="order_details[product_qty][]" value="{{ $item->qty }}">
                                <input type="hidden" name="order_details[product_price][]" value="{{ $item->price }}">
                                @endforeach
                                @endif
                                <input type="hidden" id="total_ammount" name="total_ammount" value="{{ str_replace(',', '', Cart::subTotal()) + 4.95 }}">
                                <input type="hidden" id="shiping_cost" name="shiping_cost" value="4.95">
                                <h6>Personal Information</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-item input-item-name ltn__custom-icon">
                                            <input type="text" name="firstName" style="margin-top: 20px !important; margin-bottom:0px !important;" placeholder="First name" required>
                                            <div class="invalid-feedback">Please enter your first name.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-item input-item-name ltn__custom-icon">
                                            <input type="text" name="lastName" style="margin-top: 20px !important; margin-bottom:0px !important;" placeholder="Last name" required>
                                            <div class="invalid-feedback">Please enter your last name.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-item input-item-email ltn__custom-icon">
                                            <input type="email" name="email" style="margin-top: 20px !important; margin-bottom:0px !important;" placeholder="email address" required>
                                            <div class="invalid-feedback">Please enter your email.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-item input-item-phone ltn__custom-icon">
                                            <input type="text" name="phone" style="margin-top: 20px !important; margin-bottom:0px !important;" placeholder="phone number" required>
                                            <div class="invalid-feedback">Please enter your phone No.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <h6 style="margin-top: 30px;">Address</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-item">
                                                    {{-- <input type="text" id="addressInput" name="address" placeholder="House number and street name" required> --}}

                                                    <input type="text" id="addressInput" name="address" style="margin-top: 20px !important; margin-bottom:0px !important;" placeholder="House number and street name" required>

                                                    <div class="invalid-feedback">Please enter your address.</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-item">
                                                    <input type="text" name="address2" style="margin-top: 20px !important;" placeholder="Apartment, suite, unit etc. (optional)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <h6>City</h6>
                                        <div class="input-item">
                                            <input type="text" id="cityInput" name="city" style="margin-top: 20px !important; margin-bottom:0px !important;" placeholder="City" required>
                                            <div class="invalid-feedback">Please enter your city.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <h6>Postal Code</h6>
                                        <div class="input-item">
                                            <input type="text" name="zip_code" id="zip_code_input" style="margin-top: 20px !important; margin-bottom:0px !important;" placeholder="Postal Code" required>
                                            <div class="invalid-feedback">Please enter your postal code.</div>
                                        </div>
                                    </div>
                                </div>
                                <h6 style="margin-top: 30px;">Order Notes (optional)</h6>
                                <div class="input-item input-item-textarea ltn__custom-icon">
                                    <textarea name="note" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="ltn__checkout-payment-method mt-50">
                        <h4 class="title-2">Shipping Method</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <div class="custom-control" style="display: flex; align-items:center;">
                                        <input class="form-check-input" type="radio" name="shipping_method" id="fast_delivery" value="fast" data-ship="3.95" required checked>
                                        <label class="form-check-label" for="fast_delivery"><img src="{{ url('img/48-hours.jpg') }}" alt="" style="max-width:140px !important; margin-left:10px;"></label>
                                    </div>
                                    <span class="float-right">Royal Mail Tracked 48</span>
                                    <span class="float-right"> (£3.95)</span>
                                    <div class="ml-4 mb-2 small">(3-5 working days)</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <div class="custom-control" style="display: flex; align-items:center;">
                                        <input class="form-check-input" type="radio" name="shipping_method" id="express_delivery" value="express" data-ship="4.95" required>
                                        <label class="form-check-label" for="express_delivery"><img src="{{ url('img/24-hours.jpg') }}" alt="" style="max-width:140px !important; margin-left:10px;"></label>
                                    </div>
                                    <span class="float-right">Royal Mail Tracked 24</span>
                                    <span class="float-right"> (£4.95)</span>
                                    <div class="ml-4 mb-2 small">(1-2 working days)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="shoping-cart-total mt-50">
                        <h4 class="title-2">Cart Totals</h4>
                        <table class="table">
                            <tbody>
                                @if (!empty(Cart::content()))
                                @foreach (Cart::content() as $item)
                                <tr>
                                    <td>{!! $item->name !!} {!! $item->options->variant_info ? $item->options->variant_info->new_var_info : '' !!} <strong>×
                                            {{ $item->qty }}</strong></td>
                                    <td>£{{number_format($item->subtotal, 2)}}</td>
                                </tr>
                                @endforeach
                                @endif
                                <tr>
                                    <td>Shipping and Handing</td>
                                    <td class="shipping_cost" data-shipping="3.95">£3.95</td>
                                </tr>
                                <tr>
                                    <td><strong>Order Total</strong></td>
                                    <td class="order_total">
                                        <strong>£{{number_format(str_replace(',', '', Cart::subTotal()) + 3.95, 2)}}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div style="float: right;">
                <button id="placeOrderBtn" class="btn theme-btn-1 btn-effect-1 text-uppercase" type="button" style="margin-top: 30px;">Procceed To Pay</button>
            </div>
        </form>
        <div id="iframeContainer" class="vh-100 w-100 "></div>
    </div>
</div>
<!-- WISHLIST AREA START -->


@stop

@pushOnce('scripts')
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- jQuery UI for autocomplete -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(document).ready(function() {
        // Array of cities in the United Kingdom
        var ukCities = @json($ukCities);

        $("#cityInput").autocomplete({
            source: ukCities
        });

        var ukPostalcode = @json($ukPostalcode);

        $("#zip_code_input").autocomplete({
            source: ukPostalcode
        });

        var ukAddress = @json($ukAddress);

        $("#addressInput").autocomplete({
            source: ukAddress
        });

    });
</script>
<script>
    $('input[name="shipping_method"]').change(function() {
        var shippingCost   = parseFloat($('input[name="shipping_method"]:checked').data('ship')) || 0;
        var subTotalString = @json(strval(Cart::subTotal())).replace(',', '');
        var subTotal  = parseFloat(subTotalString) || 0;
        var granTotal = parseFloat((shippingCost + subTotal).toFixed(2));
        $('.shipping_cost').text('£'+shippingCost.toFixed(2));
        $('.order_total').text('£'+granTotal.toFixed(2));
        $('#total_ammount').val(granTotal);
        $('#shiping_cost').val(shippingCost);
    });

    $(document).ready(function() {

        $('#fast_delivery').prop('checked', true);

        function validateForm() {
            var isValid = true;
            var firstName = $('input[name="firstName"]').val().trim();
            if (firstName === '') {
                isValid = false;
                $('input[name="firstName"]').addClass('is-invalid');
            } else {
                $('input[name="firstName"]').removeClass('is-invalid');
            }
            var lastName = $('input[name="lastName"]').val().trim();
            if (lastName === '') {
                isValid = false;
                $('input[name="lastName"]').addClass('is-invalid');
            } else {
                $('input[name="lastName"]').removeClass('is-invalid');
            }
            var email = $('input[name="email"]').val().trim();
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === '' || !emailPattern.test(email)) {
                isValid = false;
                $('input[name="email"]').addClass('is-invalid');
            } else {
                $('input[name="email"]').removeClass('is-invalid');
            }
            var phone = $('input[name="phone"]').val().trim();
            if (phone === '') {
                isValid = false;
                $('input[name="phone"]').addClass('is-invalid');
            } else {
                $('input[name="phone"]').removeClass('is-invalid');
            }
            var address = $('input[name="address"]').val().trim();
            if (address === '') {
                isValid = false;
                $('input[name="address"]').addClass('is-invalid');
            } else {
                $('input[name="address"]').removeClass('is-invalid');
            }
            var city = $('input[name="city"]').val().trim();
            if (city === '') {
                isValid = false;
                $('input[name="city"]').addClass('is-invalid');
            } else {
                $('input[name="city"]').removeClass('is-invalid');
            }
            var postalCode = $('input[name="zip_code"]').val().trim();
            if (postalCode === '') {
                isValid = false;
                $('input[name="zip_code"]').addClass('is-invalid');
            } else {
                $('input[name="zip_code"]').removeClass('is-invalid');
            }
            return isValid;
        }

        $('#placeOrderBtn').on('click', function() {
            if (validateForm()) {
                $('#placeOrderBtn').html('<i class="fas fa-spinner fa-spin"></i> Processing...');
                $.ajax({
                    url: $('#checkoutForm').attr('action'),
                    type: 'POST',
                    data: $('#checkoutForm').serialize(),
                    success: function(response) {


                        var redirectUrl = response.redirectUrl;
                        var iframe = $('<iframe>', {
                            src: redirectUrl,
                            frameborder: '0',
                            style: 'border: none; width: 100%; height: 100%;'
                        });
                        $('#checkoutForm').remove();
                        $('#iframeContainer').html(iframe);

                        var iframeTopPosition = $('#iframeContainer').offset().top;
                        $('html, body').animate({
                            scrollTop: iframeTopPosition
                        }, 'slow');
                    },
                    error: function(xhr, status, error) {
                        $('#placeOrderBtn').html('Proceed To Pay');
                    }
                });
            }
        });

    });
</script>
@endPushOnce