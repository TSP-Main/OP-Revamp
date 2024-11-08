@extends('web.layouts.default')
@section('title', 'Help')
@section('content')


<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-image "  data-bs-bg="img/Pharmacy4banners/help.webp">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title mt-5 text-white ">How can we help?</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/" class="text-white"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li class="text-white">How can we help?</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<div class="ltn__blog-area ltn__blog-item-3-normal mb-100 ">
        <div class="container">
            <div class="row">
                <!-- help card -->
                <div class="col-lg-3 col-sm-4 col-12">
                    <div class="ltn__blog-item ltn__blog-item-3 border-radius text-center ltn__blog-brief help_card">
                        <div class="ltn__blog-img">
                            <a href="/order_status" class="text-center"><img src="/img/help-img/order-status-icon_05f50115-6a5d-4a41-b4e5-58ab2647846d.avif" alt="#" class="text-center"></a>
                        </div>
                        <div class="help_card_title">
                            <h3 class="ltn__blog-title animated fadeIn pt-4"><a href="/order_status">Order Status</a></h3>
                        </div>
                    </div>
                </div>
                <!-- help card-->
                 <!-- help card -->
                 <div class="col-lg-3 col-sm-4 col-12">
                    <div class="ltn__blog-item ltn__blog-item-3 border-radius text-center ltn__blog-brief help_card">
                        <div class="ltn__blog-img">
                            <a href="/delivery" class="text-center"><img src="/img/help-img/delivery-icon_13a90a9c-7ab5-414c-8164-d1385ee1fd0d.webp" alt="#" class="text-center"></a>
                        </div>
                        <div class="help_card_title">
                            <h3 class="ltn__blog-title animated fadeIn pt-4"><a href="/delivery">Delivery</a></h3>
                        </div>
                    </div>
                </div>
                <!-- help card-->
                 <!-- help card -->
                 <div class="col-lg-3 col-sm-4 col-12">
                    <div class="ltn__blog-item ltn__blog-item-3 border-radius text-center ltn__blog-brief help_card">
                        <div class="ltn__blog-img">
                            <a href="/returns" class="text-center"><img src="/img/help-img/returns-icon_e08a7427-1060-467f-be59-9e422db3ac0e.avif" alt="#" class="text-center"></a>
                        </div>
                        <div class="help_card_title">
                            <h3 class="ltn__blog-title animated fadeIn pt-4"><a href="/returns">Returns</a></h3>
                        </div>
                    </div>
                </div>
                <!-- help card-->
                 <!-- help card -->
                 <div class="col-lg-3 col-sm-4 col-12">
                    <div class="ltn__blog-item ltn__blog-item-3 border-radius text-center ltn__blog-brief help_card">
                        <div class="ltn__blog-img">
                            <a href="/complaints" class="text-center"><img src="/img/help-img/complaints-icon_e81f08c7-7042-4174-8e10-863f61b2038b.avif" alt="#" class="text-center"></a>
                        </div>
                        <div class="help_card_title">
                            <h3 class="ltn__blog-title animated fadeIn pt-4"><a href="/complaints">Complaints</a></h3>
                        </div>
                    </div>
                </div>
                <!-- help card-->
            </div>
            <div class="row">
                 <!-- help card -->
                 <div class="col-lg-3 col-sm-4 col-12">
                </div>
                <!-- help card-->
                <!-- help card -->
                <div class="col-lg-3 col-sm-4 col-12">
                    <div class="ltn__blog-item ltn__blog-item-3 border-radius text-center ltn__blog-brief help_card">
                        <div class="ltn__blog-img">
                            <a href="/work" class="text-center"><img src="/img/help-img/how-it-works-icon_d1bdae8c-dec8-4318-a13d-6575770d375e.webp" alt="#" class="text-center"></a>
                        </div>
                        <div class="help_card_title">
                            <h3 class="ltn__blog-title animated fadeIn pt-4"><a href="/work">How It Works</a></h3>
                        </div>
                    </div>
                </div>
                <!-- help card-->
                 <!-- help card -->
                 <div class="col-lg-3 col-sm-4 col-12">
                    <div class="ltn__blog-item ltn__blog-item-3 border-radius text-center ltn__blog-brief help_card">
                        <div class="ltn__blog-img">
                            <a href="/faq" class="text-center"><img src="/img/help-img/faqs-icon_4faeb772-5e87-4e38-852c-83f2a05d95ec.webp" alt="#" class="text-center"></a>
                        </div>
                        <div class="help_card_title">
                            <h3 class="ltn__blog-title animated fadeIn pt-4"><a href="/faq">Frequently Asked Questions</a></h3>
                        </div>
                    </div>
                </div>
                <!-- help card-->
                 <!-- help card -->
                 <div class="col-lg-3 col-sm-4 col-12">
                </div>
                <!-- help card-->

            </div>
        </div>
    </div>

@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce
