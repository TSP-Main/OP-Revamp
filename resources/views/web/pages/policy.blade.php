@extends('web.layouts.default')
@section('title', 'Policies')
@section('content')


<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-image " data-bs-bg="img/banner/polices.png">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title mt-5 text-black"> Policies</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/" class="text-black"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li class="text-black"> Policies</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->
<div class="container pt-0 mt-0">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h1 class="text-center">Policies</h1>
            <p class="text-center">Here you can find all documents relating to our policies</p>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="container pb-5">
        <div class="row">
            <div class="col-md-3 pt-2">
                <a href="/opioid_policy" class="btn  policy-btn">Opioid Policy</a>
            </div>
            <div class="col-md-3 pt-2">
                <a href="/privacy_and_cookies_policy" class="btn  policy-btn">Privacy & Cookies Policy</a>
            </div>
            <div class="col-md-3 pt-2">
                <a href="/acceptable_use_policy" class="btn  policy-btn">Acceptable Use Policy</a>
            </div>
            <div class="col-md-3 pt-2">
                <a href="/terms_and_conditions" class="btn  policy-btn">Terms & Conditions</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 pt-2">
                <a href="/faq" class="btn  policy-btn">FAQ</a>
            </div>
            <div class="col-md-3 pt-2">
                <a href="/editorial_policy" class="btn  policy-btn">Editorial Policy</a>
            </div>
            <div class="col-md-3 pt-2">
                <a href="/returns" class="btn  policy-btn">Returns Policy</a>
            </div>
            <div class="col-md-3 pt-2">
                <a href="/dispensing_frequencies" class="btn  policy-btn">Dispensing Frequencies</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 pt-2">
                <a href="/identity_verification" class="btn  policy-btn">Identity Verification</a>
            </div>
        </div>
    </div>
</div>




@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce