@extends('web.layouts.default')
@section('title', 'Responsible Pharmacist')
@section('content')


<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-image " data-bs-bg="img/banner/Pharmacist.png">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title mt-5 text-black">Responsible Pharmacist</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/" class="text-black"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li class="text-black">Responsible Pharmacist</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->


<div class="container ">
   <div class="row">
    <div class="col-md-8">
        <h1>Responsible Pharmacist Notice</h1>
    </div>
    <div class="col-md-4">
    <p id="currentDate"></p>
    <p>Today's responsible pharmacist is</p>
        <script>
        // Get current date
        var currentDate = new Date();
        // Format options
        var options = { 
            day: 'numeric', 
            month: 'long', 
            year: 'numeric' 
        };
        // Format the date as desired
        var formattedDate = currentDate.toLocaleDateString('en-US', options); 
        // Print the formatted date to the paragraph with id="currentDate"
        document.getElementById("currentDate").innerHTML =  formattedDate;
    </script>
    </div>
   </div>
</div>

<div class="container pb-5">
    <div class="responsible pt-5">
        <p><strong class="font-weight-400">The responsible pharmacist is:</strong></p>
        <div class="mt-2">
        <a href="" class="policy-btn mt-3">Ali Awwad</a>
    </div>
    </div>
    <div class="responsible pt-5">
        <p><strong class="font-weight-400">Their registration number is:</strong></p>
        <div class="mt-2">
        <a href="" class="policy-btn">2084469</a>
    </div>
    </div>
    <div class="responsible pt-5 pb-0">
        <p><strong class="font-weight-400">Todays responsible Pharmacist is, the above named person is the pharmacist in charge of this pharmacy.</strong></p>
        <div class="mt-2">
        <a href="https://pharmacyregulation.org" class="policy-btn m-0">pharmacyregulation.org</a>
        </div>
    </div>
</div>


<div class="ltn__banner-area mt-50--- mb-100">
    <div class="container">
        <div class="row ltn__custom-gutter--- justify-content-center">
            <div class="col-lg-4 col-sm-6">
                <div class="ltn__banner-item">
                    <div class="ltn__banner-img">
                        <a href="#"><img src="img/banner/new_banner2_1.webp" alt="Banner Image" class="image-radius"></a>
                    </div>
                </div>
                <h4 class="text-center">Select your medication.</h4>
                <p class="text-center">Simply select the medication you wish to purchase by searching for it directly or by browsing the categories using the top navigation bar. It's easy!</p>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="ltn__banner-item">
                    <div class="ltn__banner-img">
                        <a href="#"><img src="img/banner/new_banner3_1.webp" alt="Banner Image" class="image-radius"></a>
                    </div>
                </div>
                <h4 class="text-center">Quick 60 secs FREE consultation.</h4>
                <p class="text-center">Once you have selected your medication, you will need to complete a FREE 1-minute consultation. Our panel of GPhC approved prescribers will check your consultation and once approved, your prescription will be dispensed by Online Pharmacy4U.</p>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="ltn__banner-item">
                    <div class="ltn__banner-img">
                        <a href="#"><img src="img/banner/new_banner4_1.webp" alt="Banner Image" calss="image-radius"></a>
                    </div>
                </div>
                <h4 class="text-center">Receive your Express delivery</h4>
                <p class="text-center">With our next-day delivery option, you can have your medications delivered to your door within hours in discreet packaging.</p>
            </div>
        </div>
    </div>
</div>




@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce