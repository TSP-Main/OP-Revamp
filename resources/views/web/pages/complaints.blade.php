@extends('web.layouts.default')
@section('title', 'Complaints')
@section('content')


<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-image " data-bs-bg="img/banner/complaint-banner.png">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title mt-5 text-black">Complaint</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/" class="text-black"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li class="text-black">Complaints</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<div class="container pt-0 pb-5">
    <div class="content-div">
        <p>All of our customers are valued and we will provide a top-quality service. We need to hear from you if something goes wrong. We will use this information to improve our standards and prevent it from happening again. You must send us a written complaint if you have a concern.</p>
        <p>Please contact the following address if you have a complaint about a pharmacy-related incident:</p>
        <p>Online pharmacy 4U</p>
        <h6>Unit 2 Mansfield Station Gateway, Nottingham NG19 9QH,
            <br>United Kingdom
        </h6>
        <p>Telephone: 01623 572757</p>
        <p>Email: info@online-pharmacy4u.co.uk</p>
        <p>We aim to address all written complaints within two days of receiving them. All substantive complaints will be addressed within five days.</p>
        <p>If you are unhappy with the way we handled your complaint, you can contact the General Pharmaceutical Council by phone: 020 3365 3400 or online:   <a href="https://www.pharmacyregulation.org/contact-us/"> www.pharmacyregulation.org/contact-us/</a>.</p>
    </div>
</div>

@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce