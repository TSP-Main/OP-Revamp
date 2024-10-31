@extends('web.layouts.default', ['menu_categories' => $menu_categories])
@section('title', 'Home')
@section('content')
    <style>
        @media (min-width: 600px) and (max-width: 991px) {
            .tabPadding {
                text-align: center;
                padding-bottom: 46px;
            }
        }

        #div {
            width: 100%;
            height: 450px;
            background-image: url('/img/banner/web_banner_2.webp');
            background-size: 100% 100%;
        }

        #div1 {
            width: 100%;
            height: 450px;
            background-image: url('/img/banner/twoo.webp');
            background-size: 100% 100%;
        }

        #div2 {
            width: 100%;
            height: 450px;
            background-image: url('/img/banner/web_banner_7.webp');
            background-size: 100% 100%;
        }

        .ltn__product-item {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-img {
            flex: 1 1 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 200px;
            /* Adjust height as necessary */
        }

        .product-info {
            flex: 0 0 auto;
            padding: 10px;
            /* Add padding if needed */
            text-align: left;
        }
    </style>
    <!-- SLIDER AREA START (slider-3) -->
    <div class="ltn__slider-area ltn__slider-3 desktop-slider  section-bg-1 ">
        <div class="ltn__slide-one-active slick-slide-arrow-1 slick-slide-dots-1">
            <!-- ltn__slide-item -->
            <div class="">
                <a href="https://onlinepharmacy-4u.co.uk/product/canesoasis-cystitis-relief-4g-x-6-sachets">
                    <div id="div"></div>
                </a>
            </div>
            <div class="">
                <a href="https://onlinepharmacy-4u.co.uk/product/colief-baby-scalp-oil-30ml">
                    <div id="div1"></div>
                </a>
            </div>
            <div class="">
                <a href="https://onlinepharmacy-4u.co.uk/product/vitality-cbd-muscle-joint-gel-500mg-100ml">
                    <div id="div2"></div>
                </a>
            </div>
            <!--  -->
        </div>
    </div>
    <!-- SLIDER AREA END -->
    <!-- SLIDER AREA  for mobile START (slider-3) -->
    <div class="ltn__slider-area ltn__slider-3 mobile-slider  section-bg-1 ">
        <div class="ltn__slide-one-active slick-slide-arrow-1 slick-slide-dots-1">
            <!-- ltn__slide-item -->
            <div class="ltn__slide-item ltn__slide-item-2  ltn__slide-item-3-normal--- ltn__slide-item-3 bg-image " br
                 data-bs-bg="img/banner/mob1.webp">
                <div class="ltn__slide-item-inner  text-left">
                    <div class="container d-none">
                        <div class="row">
                            <div class="col-lg-12 align-self-center">
                                <div class="slide-item-info">
                                    <div class="slide-item-info-inner ltn__slide-animation">

                                        <h5 class="slide-title animated text-black poppins-medium">Repeat Prescriptions,<br>
                                            Made Simple.</h5>
                                        <div class="slide-brief animated">
                                            <p class=" text-black oppins-extralight">Order with ease and get your NHS
                                                repeat prescriptions delivered directly to your door </br>with Online
                                                Pharmacy 4U
                                                Sign-up in seconds<br>
                                                ✓ Free delivery to your home or workplace<br>
                                                ✓Discreet packaging</p>
                                        </div>
                                        <div class="btn-wrapper animated">
                                            <a href="https://healthera.co.uk/app" target="blank"
                                               class="theme-btn-1 btn oppins-extralight">Register Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ltn__slide-item -->
            <div class="ltn__slide-item ltn__slide-item-2 ltn__slide-item-3-normal--- ltn__slide-item-3 bg-image"
                 data-bs-bg="img/banner/nomore.webp">
                <div class="ltn__slide-item-inner text-left">
                    <div class="container d-none">
                        <div class="row">
                            <div class="col-lg-12 align-self-center">
                                <div class="slide-item-info">
                                    <div class="slide-item-info-inner ltn__slide-animation">
                                        <div class="slide-video mb-50 d-none">
                                            <a class="ltn__video-icon-2 ltn__video-icon-2-border"
                                               href="https://www.youtube.com/embed/tlThdr3O5Qo"
                                               data-rel="lightcase:myCollection">
                                                <i class="fa fa-play"></i>
                                            </a>
                                        </div>
                                        <!-- <h6 class="slide-sub-title white-color--- animated text-black"><span><i class="fas fa-syringe"></i></span> Regulated UK Pharmacist</h6> -->
                                        <h5 class="slide-title animated text-black poppins-medium">Rediscover Passion &
                                            Reignite That Spark</h5>
                                        <div class="slide-brief animated">
                                            <p class="text-black oppins-extralight">Don't Let ED Put A Wedge Between You
                                                And Your Partner. Shop Our Range Of ED Medications!</p>
                                        </div>
                                        <div class="btn-wrapper animated">
                                            <a href="/shop" class="theme-btn-1 btn ">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ltn__slide-item -->
            <div class="ltn__slide-item ltn__slide-item-2  ltn__slide-item-3-normal--- ltn__slide-item-3  bg-image"
                 data-bs-bg="img/banner/mob3.webp">
                <div class="ltn__slide-item-inner  text-left">
                    <div class="container d-none">
                        <div class="row">
                            <div class="col-lg-12 align-self-center">
                                <div class="slide-item-info">
                                    <div class="slide-item-info-inner ltn__slide-animation">
                                        <!-- <h6 class="slide-sub-title white-color--- animated  text-black"><span><i class="fas fa-syringe"></i></span> Regulated UK Pharmacist</h6> -->
                                        <h5 class="slide-title animated  text-black poppins-medium">Beat Travel Sickness
                                            And See The World</h5>
                                        <div class="slide-brief animated">
                                            <p class="text-black  oppins-extralight">Convenient And Easy To Take
                                                Tablets-Great For On The Go Clinically Proven To Provide Relief From
                                                Nausea Reliefs Feelings Of Motion Sickness Quickly And Effectively Take
                                                As Need For All-Day Relief And Comfort</p>
                                        </div>
                                        <div class="btn-wrapper animated">
                                            <a href="/shop" class="theme-btn-1 btn ">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
    </div>
    <!-- SLIDER AREA END -->

    <!-- resources/views/import.blade.php -->
    {{-- <form action="{{ route('import.users') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="csv_file">Choose CSV file</label>
            <input type="file" name="csv" id="csv_file" required>
        </div>
        <button type="submit">Import Users</button>
    </form>
    <form action="{{ route('import.orders') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="csv_file">Choose CSV file</label>
            <input type="file" name="csv" id="csv_file" required>
        </div>
        <button type="submit">Import Orders</button>
    </form>
    <form action="{{ route('import.ordersDetails') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="csv_file">Choose CSV file</label>
            <input type="file" name="csv" id="csv_file" required>
        </div>
        <button type="submit">Import Orders Details</button>
    </form>
    <form action="{{ route('import.shippingDetails') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="csv_file">Choose CSV file</label>
            <input type="file" name="csv" id="csv_file" required>
        </div>
        <button type="submit">Import Shipping Details</button>
    </form>
    <form action="{{ route('import.importPaymentDetails') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="csv_file">Choose CSV file</label>
            <input type="file" name="csv" id="csv_file" required>
        </div>
        <button type="submit">Import Payment Details</button>
    </form> --}}


    <!-- Featured Offers area start  -->
    <div class="featured-offers-area pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="feature-offer-heading">
                        <h1 class="text-white poppins-medium">Featured Offers</h1>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-radius">
                        <a href="/skincare"><img src="img/product/calypso.webp" class="card-img-top card-radius"
                                                 alt="..."
                                                 style="border-bottom-left-radius: 0px; border-bottom-right-radius: 0px;"></a>
                        <div class="card-body" style="text-align: center;">
                            <!-- <h5 class="card-title poppins-medium">Skincare</h5> -->
                            <p class="card-text  oppins-extralight" style="font-size: 12px;">Enjoy a cruelty-free,
                                vegan-friendly formula that helps prolong your tan and provides healing benefits.</p>
                            <!-- <a href="/skincare" class="btn btn-primary theme-btn-1">Buy Now</a> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-radius">
                        <a href="{{ url('/search?q=freestyle') }}"><img src="img/product/chan.webp"
                                                                                            class="card-img-top card-radius"
                                                                                            alt="..."
                                                                                            style="border-bottom-left-radius: 0px; border-bottom-right-radius: 0px;"></a>
                        <div class="card-body tabPadding" style="text-align: center;">
                            <!-- <h5 class="card-title">Sleep</h5> -->
                            <p class="card-text" style="font-size: 12px;">Easily monitor your blood sugar levels with
                                the Freestyle Libre 2 Sensor – no finger pricks needed.</p>
                            <!-- <a href="/sleep" class="btn btn-primary theme-btn-1">Buy Now</a> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-radius">
                        <a href="{{ url('/pharmacy-shop/travel-health') }}"><img src="img/product/jungle formula.webp"
                                                                   class="card-img-top card-radius" alt="..."
                                                                   style="border-bottom-left-radius: 0px; border-bottom-right-radius: 0px;"></a>
                        <div class="card-body tabPadding" style="text-align: center;">
                            <!-- <h5 class="card-title">Diabetes</h5> -->
                            <p class="card-text" style="font-size: 12px;">Choose the right protection with IRF, offering
                                up to 9 hours of defense against biting insects.</p>
                            <!-- <a href="/diabetes" class="btn btn-primary theme-btn-1">Buy Now</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured Offers area end  -->


    <!-- CATEGORY AREA START -->
    <div class="ltn__category-area section-bg-1-- pt-50 pb-90">
        <div class="container">
            <div class="row ltn__category-slider-active-six slick-arrow-1 border-bottom">
                <div class="col-12">
                    <div class="ltn__category-item ltn__category-item-6 text-center">
                        <div class="ltn__category-item-img">
                            <a href="shop.html">
                                <i class="fas fa-notes-medical"></i>
                            </a>
                        </div>
                        <div class="ltn__category-item-name">
                            <h6><a href="shop.html">Best Deals</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="ltn__category-item ltn__category-item-6 text-center">
                        <div class="ltn__category-item-img">
                            <a href="shop.html">
                                <i class="fas fa-box-tissue"></i>
                            </a>
                        </div>
                        <div class="ltn__category-item-name">
                            <h6><a href="shop.html">Germs Pads</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="ltn__category-item ltn__category-item-6 text-center">
                        <div class="ltn__category-item-img">
                            <a href="shop.html">
                                <i class="fas fa-pump-medical"></i>
                            </a>
                        </div>
                        <div class="ltn__category-item-name">
                            <h6><a href="shop.html">Accessories</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="ltn__category-item ltn__category-item-6 text-center">
                        <div class="ltn__category-item-img">
                            <a href="shop.html">
                                <i class="fas fa-bong"></i>
                            </a>
                        </div>
                        <div class="ltn__category-item-name">
                            <h6><a href="shop.html">Medicine Cap</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="ltn__category-item ltn__category-item-6 text-center">
                        <div class="ltn__category-item-img">
                            <a href="shop.html">
                                <i class="fas fa-tooth"></i>
                            </a>
                        </div>
                        <div class="ltn__category-item-name">
                            <h6><a href="shop.html">Dental Item</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="ltn__category-item ltn__category-item-6 text-center">
                        <div class="ltn__category-item-img">
                            <a>
                                <i class="fas fa-microscope"></i>
                            </a>
                        </div>
                        <div class="ltn__category-item-name">
                            <h6><a href="shop.html">Best Deals</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="ltn__category-item ltn__category-item-6 text-center">
                        <div class="ltn__category-item-img">
                            <a href="shop.html">
                                <i class="fas fa-syringe"></i>
                            </a>
                        </div>
                        <div class="ltn__category-item-name">
                            <h6><a href="shop.html">All Products</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="ltn__category-item ltn__category-item-6 text-center">
                        <div class="ltn__category-item-img">
                            <a href="shop.html">
                                <i class="fas fa-stethoscope"></i>
                            </a>
                        </div>
                        <div class="ltn__category-item-name">
                            <h6><a href="shop.html">Germs Pads</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="ltn__category-item ltn__category-item-6 text-center">
                        <div class="ltn__category-item-img">
                            <a href="shop.html">
                                <i class="fas fa-hand-holding-medical"></i>
                            </a>
                        </div>
                        <div class="ltn__category-item-name">
                            <h6><a href="shop.html">Accessories</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="ltn__category-item ltn__category-item-6 text-center">
                        <div class="ltn__category-item-img">
                            <a href="shop.html">
                                <i class="fas fa-procedures"></i>
                            </a>
                        </div>
                        <div class="ltn__category-item-name">
                            <h6><a href="shop.html">Medicine Cap</a></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CATEGORY AREA END -->

    <!-- ABOUT US AREA START -->
    <div class="ltn__about-us-area pt-25 pb-120 ">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="about-us-img-wrap about-img-left">
                        <img src="img/others/9.webp" alt="About Us Image" class="image-radius">
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="about-us-info-wrap">
                        <div class="section-title-area ltn__section-title-2--- mb-30">
                            <h6 class="section-subtitle section-subtitle-2 ltn__secondary-color d-none">About Us</h6>
                            <h1 class="section-title"> Healthcare Professionals <br> at Online Pharmacy 4U</h1>
                            <p>Our Healthcare Professionals here at Online Pharmacy 4U get asked hundreds of questions
                                regards symptoms and treatments daily, visit our A to Z Conditions & Treatments finder
                                to find what you are looking for.</p>
                        </div>
                        <ul class="ltn__list-item-1 ltn__list-item-1-before--- clearfix">
                            <li><i class="fas fa-check-square"></i> Watch our explainer video</li>
                            <li><i class="fas fa-check-square"></i> Helps explain some of the</li>
                            <li><i class="fas fa-check-square"></i> Common conditions</li>
                            <li><i class="fas fa-check-square"></i> Watch ''how we work'' Video!</li>
                            <li><a href="https://www.youtube.com/@onlinepharmacy4u468" class="btn theme-btn-1">Our
                                    YouTube Channel</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ABOUT US AREA END -->

    <!-- BANNER AREA START -->
    <div class="ltn__banner-area mt-120---">
        <div class="container">
            <div class="row ltn__custom-gutter--- justify-content-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__banner-item">
                        <div class="ltn__banner-img">
                            <a><img src="img/banner/new_banner2_1.webp" alt="Banner Image" class="image-radius"></a>
                        </div>
                    </div>
                    <h4 class="text-center">Select your medication</h4>
                    <p class="text-center">Simply select the medication you wish to purchase by searching for it
                        directly or by browsing the categories using the top navigation bar. It's easy!</p>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__banner-item">
                        <div class="ltn__banner-img">
                            <a><img src="img/banner/new_banner3_1.webp" alt="Banner Image" class="image-radius"></a>
                        </div>
                    </div>
                    <h4 class="text-center">Quick 60 secs FREE consultation</h4>
                    <p class="text-center">Once you have selected your medication, you will need to complete a FREE
                        1-minute consultation. Our panel of GPhC approved prescribers will check your consultation and
                        once approved, your prescription will be dispensed by Online Pharmacy4U.</p>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__banner-item">
                        <div class="ltn__banner-img">
                            <a><img src="img/banner/new_banner4_1.webp" alt="Banner Image" calss="image-radius"></a>
                        </div>
                    </div>
                    <h4 class="text-center">Receive your Express delivery</h4>
                    <p class="text-center">With our next-day delivery option, you can have your medications delivered to
                        your door within hours in discreet packaging.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- BANNER AREA END -->

    <!-- PRODUCT AREA START (product-item-3) -->
    <div class="ltn__product-area ltn__product-gutter  no-product-ratting pt-85 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2 text-center">
                        <h1 class="section-title">Featured Products</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 d-none">
                    <div class="row">
                        <div class="col-lg-12 col-sm-6">
                            <div class="ltn__banner-item">
                                <div class="ltn__banner-img">
                                    <a href="shop.html"><img src="img/banner/banner11.png" alt="Banner Image"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-6">
                            <div class="ltn__banner-item">
                                <div class="ltn__banner-img">
                                    <a href="shop.html"><img src="img/banner/12.webp" alt="Banner Image"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row ltn__tab-product-slider-one-active--- slick-arrow-1">
                        <!-- ltn__product-item -->
                        @if($products)
                            @foreach ($products as $key => $val)
                                <div class="col-lg-3--- col-md-4 col-sm-6 col-6" style="margin-bottom: 50px;">
                                    <div class="ltn__product-item ltn__product-item-2 text-left">
                                        <div class="product-img">
                                            {{-- <a href="product-details.html">
                                                        <img src="{{ asset('storage/'.$val['main_image']) }}" alt="#">
                                            </a> --}}
                                            <img src="{{ asset('storage/'.$val['main_image']) ?? '' }}" alt="image">
                                            <div class="product-badge">
                                                <ul>
                                                    <li class="sale-badge">New</li>
                                                </ul>
                                            </div>
                                            <div class="product-hover-action">
                                                <ul>
                                                    @if($val->stock_status == 'IN')
                                                        @if($val['product_template'] == config('constants.COUNTER_MEDICINE'))
                                                            <li>
                                                                <a href="{{ route('web.product', ['id' => $val['slug']]) }}">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)"
                                                                   onclick="addToCart({{ $val->id }});"
                                                                   class="theme-btn-1 btn btn-effect-1"
                                                                   title="Add to Cart">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                        @else
                                                            <!-- <li>
                                            <a  title="You have to answer some question">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </li> -->
                                                        @endif
                                                    @else
                                                        <a class="btn btn-secondary disabled" title="Out of Stock"
                                                           aria-disabled="true">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                        </a>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <h2 class="product-title"><a
                                                    href="{{ route('web.product', ['id' => $val['slug']]) }}">{{ $val['title'] }}</a>
                                            </h2>
                                            <div class="product-price">
                                                <span>£{{ $val['price'] }}</span>
                                                <del>{{ $val['cut_price'] ? '£'.$val['cut_price'] : NULL}}</del>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <!--  -->
                    </div>
                </div>
            </div>
            <div class="text-center product-btn">
                <a href="{{route('shop')}}" class="theme-btn-1 btn btn-effect-3 card-radius">
                    <!-- <i class="fas fa-shopping-cart"></i> -->
                    <span> View All Products</span>
                </a>
            </div>

        </div>
    </div>
    <!-- PRODUCT AREA END -->


    <!-- COUNTDOWN AREA START -->
    <div class="ltn__call-to-action-area section-bg-1 countdown-section pt-20 pb-20">
        <div class="container">
            <div class="row py-5">
                <div class="col-lg-6">
                    <div class="conunt-heading">
                        <h2 class="pt-4">Hay Fever & Allergy Symptom Relief</h2>
                        <p>Offering fast and discreet delivery for all our medicines & treatments. Get your order
                            delivered quickly, with complete privacy.</p>
                        <br>
                        <p>Get quick relief from</p>
                        <ul>
                            <li>Sneezing</li>
                            <li>Runny & Itchy Nose</li>
                            <li>Eye Irritation</li>
                        </ul>
                        <!-- <p><strong>We respect that many of our products are of a sensitive nature - this is why we take every step to keep your purchases private.</strong></p> -->
                    </div>
                    <a href="{{url('/collections/pharmacy-shop/hayfever-allergy-relief') }}"
                       class="theme-btn-1 btn mt-2">Click to Buy Now</a>
                </div>
                <div class="col-lg-6">
                    <img src="img/banner/ing.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- COUNTDOWN AREA END -->



    <!-- ABOUT US AREA START -->
    <div class="ltn__about-us-area bg-overlay-white-90--- bg-image pt-115 pb-110 display-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="about-us-img-wrap about-img-left">
                        <img src="img/allbanners/home3.png" alt="About Us Image">
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="about-us-info-wrap">
                        <div class="section-title-area ltn__section-title-2--- mb-20">
                            <h6 class="section-subtitle section-subtitle-2--- ltn__secondary-color">N95 Facial Covering
                                Mask</h6>
                            <h1 class="section-title">Grade A Safety Masks
                                For Sale. Haurry Up!</h1>
                            <p>Over 39,000 people work for us in more than 70 countries all over the
                                This breadth of global coverage, combined with specialist services</p>
                        </div>
                        <ul class="ltn__list-item-half clearfix">
                            <li>
                                <i class="flaticon-home-2"></i>
                                Activated Carbon
                            </li>
                            <li>
                                <i class="flaticon-mountain"></i>
                                Breathing Valve
                            </li>
                            <li>
                                <i class="flaticon-heart"></i>
                                6 Layer Filteration
                            </li>
                            <li>
                                <i class="flaticon-secure"></i>
                                Rewashes & Reusable
                            </li>
                        </ul>
                        <div class="btn-wrapper animated">
                            <a href="/shop" class="ltn__secondary-color text-uppercase text-decoration-underline">View
                                Products</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ABOUT US AREA END -->



    <!-- BANNER AREA START -->
    <div class="ltn__banner-area mt-120--- mt-5">
        <div class="container">
            <div class="row ltn__custom-gutter--- justify-content-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__banner-item">
                        <div class="ltn__banner-img">
                            <a href="{{url('collections/online-clinic/mens-health') }}"><img
                                    src="img/banner/Men_s_Health_400x.webp" alt="Banner Image"></a>
                            <h4 class="text-center mt-3">Men Health</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__banner-item">
                        <div class="ltn__banner-img">
                            <a href="{{url('collections/online-clinic/womens-health') }}"><img
                                    src="img/banner/Women_s_Health_400x.webp" alt="Banner Image"></a>
                            <h4 class="text-center  mt-3">Women Health</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__banner-item">
                        <div class="ltn__banner-img">
                            <a href="{{url('collections/general-health') }}"><img
                                    src="img/banner/General_Health_400x.webp" alt="Banner Image"></a>
                            <h4 class="text-center mt-3">General Health</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BANNER AREA END -->



    <!-- BLOG AREA START (blog-3) -->
    <div class="ltn__blog-area pt-115 pb-45">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2--- text-center">
                        <h6 class="section-subtitle section-subtitle-2 ltn__secondary-color d-none">News & Blogs</h6>
                        <h1 class="section-title">Leatest Blogs</h1>
                    </div>
                </div>
            </div>
            <div class="row  ltn__blog-slider-one-active slick-arrow-1 ltn__blog-item-3-normal pb-100">
                <!-- Blog Item 1 -->
                <div class="col-lg-12">
                    <div class="ltn__blog-item ltn__blog-item-3 ">
                        <div class="ltn__blog-img">
                            <a><img src="img/blog/blog-one.png" alt="#"></a>
                        </div>
                        <div class="ltn__blog-brief">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-author">
                                        <a><i class="far fa-user"></i>by: Admin</a>
                                    </li>
                                    <li class="ltn__blog-tags">
                                        <a><i class="fas fa-tags"></i>Sports</a>
                                    </li>
                                </ul>
                            </div>
                            <h5 class=""><a>Path to Athletic Excellence through Sports Performance</a></h5>
                            <div class="ltn__blog-meta-btn">
                                <div class="ltn__blog-meta">
                                    <ul>
                                        <li class="ltn__blog-date"><i class="far fa-calendar-alt"></i>March 1, 2024</li>
                                    </ul>
                                </div>
                                <div class="ltn__blog-btn">
                                    <a>Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Item 2-->
                <div class="col-lg-12">
                    <div class="ltn__blog-item ltn__blog-item-3 ">
                        <div class="ltn__blog-img">
                            <a><img src="img/blog/blog-2.png" alt="#"></a>
                        </div>
                        <div class="ltn__blog-brief">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-author">
                                        <a><i class="far fa-user"></i>by: Admin</a>
                                    </li>
                                    <li class="ltn__blog-tags">
                                        <a><i class="fas fa-tags"></i>Sports</a>
                                    </li>
                                </ul>
                            </div>
                            <h5 class=""><a>Sports Performance Tests Redefine the Game</a></h5>
                            <div class="ltn__blog-meta-btn">
                                <div class="ltn__blog-meta">
                                    <ul>
                                        <li class="ltn__blog-date"><i class="far fa-calendar-alt"></i>March 1, 2024</li>
                                    </ul>
                                </div>
                                <div class="ltn__blog-btn">
                                    <a>Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Item 3-->
                <div class="col-lg-12 ">
                    <div class="ltn__blog-item ltn__blog-item-3 ">
                        <div class="ltn__blog-img">
                            <a><img src="img/blog/blog-3.png" alt="#"></a>
                        </div>
                        <div class="ltn__blog-brief">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-author">
                                        <a><i class="far fa-user"></i>by: Admin</a>
                                    </li>
                                    <li class="ltn__blog-tags">
                                        <a><i class="fas fa-tags"></i>Sports</a>
                                    </li>
                                </ul>
                            </div>
                            <h5 class=""><a>Transforming Your Athletic Journey with Performance Tests</a></h5>
                            <div class="ltn__blog-meta-btn">
                                <div class="ltn__blog-meta">
                                    <ul>
                                        <li class="ltn__blog-date"><i class="far fa-calendar-alt"></i>March 1, 2024</li>
                                    </ul>
                                </div>
                                <div class="ltn__blog-btn">
                                    <a>Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Item -->
                <div class="col-lg-12 d-none">
                    <div class="ltn__blog-item ltn__blog-item-3">
                        <div class="ltn__blog-img">
                            <a href="blog-details.html"><img src="img/blog/4.jpg" alt="#"></a>
                        </div>
                        <div class="ltn__blog-brief">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-author">
                                        <a><i class="far fa-user"></i>by: Admin</a>
                                    </li>
                                    <li class="ltn__blog-tags">
                                        <a><i class="fas fa-tags"></i>Room</a>
                                    </li>
                                </ul>
                            </div>
                            <h3 class="ltn__blog-title"><a href="blog-details.html">Renovating a Living Room? Experts
                                    Share Their Secrets</a></h3>
                            <div class="ltn__blog-meta-btn">
                                <div class="ltn__blog-meta">
                                    <ul>
                                        <li class="ltn__blog-date"><i class="far fa-calendar-alt"></i>June 24, 2021</li>
                                    </ul>
                                </div>
                                <div class="ltn__blog-btn">
                                    <a href="blog-details.html">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Item -->
                <div class="col-lg-12 d-none">
                    <div class="ltn__blog-item ltn__blog-item-3">
                        <div class="ltn__blog-img">
                            <a href="blog-details.html"><img src="img/blog/5.jpg" alt="#"></a>
                        </div>
                        <div class="ltn__blog-brief">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-author">
                                        <a><i class="far fa-user"></i>by: Admin</a>
                                    </li>
                                    <li class="ltn__blog-tags">
                                        <a><i class="fas fa-tags"></i>Trends</a>
                                    </li>
                                </ul>
                            </div>
                            <h3 class="ltn__blog-title"><a href="blog-details.html">7 home trends that will shape your
                                    house in 2021</a></h3>
                            <div class="ltn__blog-meta-btn">
                                <div class="ltn__blog-meta">
                                    <ul>
                                        <li class="ltn__blog-date"><i class="far fa-calendar-alt"></i>June 24, 2021</li>
                                    </ul>
                                </div>
                                <div class="ltn__blog-btn">
                                    <a href="blog-details.html">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
            </div>
        </div>
    </div>
    <!-- BLOG AREA END -->

    <!-- BRAND LOGO AREA START -->
    <div class="container-fluid p-0 m-0 home-page-last-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="footer-branding-section">
                        <h1 class="text-center">Access to healthcare made Easy, Fast & Affordable!</h1>
                        <p class="text-center">Everyone deserves access to health and wellness in the simplest, most
                            convenient and affordable way.</p>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="footer-cards ">
                        <div class="row">
                            <div class="col-md-2">
                                <h3 class="text-white"><i class="fas fa-heart"></i></h3>
                            </div>
                            <div class="col-md-10">
                                <h3 class="text-white">Value</h3>
                            </div>
                            <div class="col-md-12">
                                <p class="text-white">The nation's favourite brands at a price you'll love. </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-cards ">
                        <div class="row">
                            <div class="col-md-2">
                                <h3 class="text-white"><i class="fas fa-truck"></i></h3>
                            </div>
                            <div class="col-md-10">
                                <h3 class="text-white">Convenience</h3>
                            </div>
                            <div class="col-md-12">
                                <p class="text-white">Prescriptions delivered free together with your health.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-cards ">
                        <div class="row">
                            <div class="col-md-2">
                                <h3 class="text-white"><i class="fas fa-box-open"></i></h3>
                            </div>
                            <div class="col-md-10">
                                <h3 class="text-white">Choice</h3>
                            </div>
                            <div class="col-md-12">
                                <p class="text-white">Wide range of health & wellness products & services.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-cards ">
                        <div class="row">
                            <div class="col-md-2">
                                <h3 class="text-white"><i class="fas fa-shield-alt"></i></h3>
                            </div>
                            <div class="col-md-10">
                                <h3 class="text-white">Empathy</h3>
                            </div>
                            <div class="col-md-12">
                                <p class="text-white">We're here to help you feel better for less.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BRAND LOGO AREA END -->








    <!-- MODAL AREA START (Quick View Modal) -->
    <div class="ltn__modal-area ltn__quick-view-modal-area">
        <div class="modal fade" id="quick_view_modal" tabindex="-1">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <!-- <i class="fas fa-times"></i> -->
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="ltn__quick-view-modal-inner">
                            <div class="modal-product-item">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="modal-product-img">
                                            <img src="img/product/4.png" alt="#">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="modal-product-info">
                                            <div class="product-ratting">
                                                <ul>
                                                    <li><a><i class="fas fa-star"></i></a></li>
                                                    <li><a><i class="fas fa-star"></i></a></li>
                                                    <li><a><i class="fas fa-star"></i></a></li>
                                                    <li><a><i class="fas fa-star-half-alt"></i></a></li>
                                                    <li><a><i class="far fa-star"></i></a></li>
                                                    <li class="review-total"><a> ( 95 Reviews )</a></li>
                                                </ul>
                                            </div>
                                            <h3><a href="product-details.html">Digital Stethoscope</a></h3>
                                            <div class="product-price">
                                                <span>$15.00</span>
                                                <del>$25.00</del>
                                            </div>
                                            <hr>
                                            <div class="modal-product-brief">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos
                                                    repellendus repudiandae incidunt quidem pariatur expedita, quo quis
                                                    modi tempore non.</p>
                                            </div>
                                            <!-- <hr> -->
                                            <div class="ltn__product-details-menu-3">
                                                <ul>
                                                    <li>
                                                        <a class="" title="Wishlist" data-bs-toggle="modal"
                                                           data-bs-target="#liton_wishlist_modal">
                                                            <i class="far fa-heart"></i>
                                                            <span>Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="" title="Compare" data-bs-toggle="modal"
                                                           data-bs-target="#quick_view_modal">
                                                            <i class="fas fa-exchange-alt"></i>
                                                            <span>Compare</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <hr>
                                            <div class="ltn__social-media">
                                                <ul>
                                                    <li>Share:</li>
                                                    <li><a title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                                    <li><a title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                                    <li><a title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                                                    <li><a title="Instagram"><i class="fab fa-instagram"></i></a></li>

                                                </ul>
                                            </div>
                                            <label class="float-end mb-0"><a class="text-decoration"
                                                                             href="product-details.html"><small>View
                                                        Details</small></a></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL AREA END -->

    <!-- MODAL AREA START (Add To Cart Modal) -->
    <div class="ltn__modal-area ltn__add-to-cart-modal-area">
        <div class="modal fade" id="add_to_cart_modal" tabindex="-1">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="ltn__quick-view-modal-inner">
                            <div class="modal-product-item">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="modal-product-img">
                                            <img src="img/product/1.png" alt="#">
                                        </div>
                                        <div class="modal-product-info">
                                            <h5><a href="product-details.html">Digital Stethoscope</a></h5>
                                            <p class="added-cart"><i class="fa fa-check-circle"></i> Successfully added
                                                to your Cart</p>
                                            <div class="btn-wrapper">
                                                <a href="{{route('web.view.cart')}}"
                                                   class="theme-btn-1 btn btn-effect-1">View Cart</a>
                                                <a href="{{route('web.checkout')}}"
                                                   class="theme-btn-2 btn btn-effect-2">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL AREA END -->

    <!-- MODAL AREA START (Wishlist Modal) -->
    <div class="ltn__modal-area ltn__add-to-cart-modal-area">
        <div class="modal fade" id="liton_wishlist_modal" tabindex="-1">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="ltn__quick-view-modal-inner">
                            <div class="modal-product-item">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="modal-product-img">
                                            <img src="img/product/7.png" alt="#">
                                        </div>
                                        <div class="modal-product-info">
                                            <h5><a href="product-details.html">Digital Stethoscope</a></h5>
                                            <p class="added-cart"><i class="fa fa-check-circle"></i> Successfully added
                                                to your Wishlist</p>
                                            <div class="btn-wrapper">
                                                <a href="wishlist.html" class="theme-btn-1 btn btn-effect-1">View
                                                    Wishlist</a>
                                            </div>
                                        </div>
                                        <!-- additional-info -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL AREA END -->




    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-2"></div>
                <div class="col-md-4 col-sm-2"></div>
                <div class="col-md-4 col-sm-2"></div>
                <div class="col-md-4 col-sm-2"></div>
            </div>
        </div>
    </section>

@stop

@pushOnce('scripts')
    <script>

    </script>
@endPushOnce
