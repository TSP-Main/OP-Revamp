@extends('web.layouts.default')
@section('title', 'Order Tracking')
@section('content')

    
<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-image "  data-bs-bg="img/Pharmacy4banners/help.webp">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title mt-5 text-white">Order Tracking</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/" class="text-white"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li class="text-white">Order Tracking</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->
<!-- LOGIN AREA START -->
    <div class="ltn__login-area mb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="account-login-inner section-bg-1">
                        <form action="#" class="ltn__form-box contact-form-box">
                            <p class="text-center"> To track your order please enter your Order ID in the box below and press the "Track Order" button. This was given to you on your receipt and in the confirmation email you should have received. </p>
                            <label>Order ID</label>
                            <input type="text" name="email" placeholder="Found in your order confirmation email.">
                            <label>Billing email</label>
                            <input type="text" name="email" placeholder="Email you used during checkout.">
                            <div class="btn-wrapper mt-0 text-center">
                                <button class="btn theme-btn-1 btn-effect-1 text-uppercase" type="submit">Track Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce