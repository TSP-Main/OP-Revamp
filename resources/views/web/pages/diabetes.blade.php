@extends('web.layouts.default')
@section('title', 'Diabetes')
@section('content')

<style>
    /* Custom card styles */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s;
    }

    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-img-top {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        max-height: 200px;
        object-fit: cover;
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .card-text {
        font-size: 1rem;
        color: #555;
    }

    .btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 15px;
        padding: 10px;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #0056b3;
        color: #fff;
    }
</style>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-image " data-bs-bg="img/banner/Diabetes.png">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title mt-5">Diabetes</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li>Diabetes</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

 <!-- PRODUCT DETAILS AREA START -->
 <div class="ltn__product-area ltn__product-gutter mb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 order-lg-2 mb-120">
                    <div class="ltn__shop-options">
                        <ul>
                            <li>
                                <div class="ltn__grid-list-tab-menu ">
                                    <div class="nav">
                                        {{-- <a class="active show" data-bs-toggle="tab" href="#liton_product_grid"><i class="fas fa-th-large"></i></a> --}}
                                        {{-- <a data-bs-toggle="tab" href="#liton_product_list"><i class="fas fa-list"></i></a> --}}
                                    </div>
                                </div>
                            </li>
                            <li>
                               <div class="showing-product-number text-right">
                                    {{-- <span>Showing 1–12 of 18 results</span> --}}
                                </div>
                            </li>
                            <li class="d-none">
                               <div class="short-by text-center">
                                    <select class="nice-select">
                                        <option>Default Sorting</option>
                                        <option>Sort by popularity</option>
                                        <option>Sort by new arrivals</option>
                                        <option>Sort by price: low to high</option>
                                        <option>Sort by price: high to low</option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="liton_product_grid">
                            <div class="ltn__product-tab-content-inner ltn__product-grid-view">
                                <div class="row">
                                    <!-- ltn__product-item -->
                                    @if ($products)
                                        @foreach ($products as $product)
                                            <div class="col-xl-4 col-sm-6 col-6">
                                                <div class="ltn__product-item ltn__product-item-3 text-center">
                                                    <div class="product-img">
                                                        <a href="{{ route('web.product', ['id' => $product->id]) }}"><img src="{{asset('storage/'.$product->main_image)}}" alt="#"></a>
                                                        <div class="product-badge">
                                                            <ul>
                                                                <li class="sale-badge d-none">New</li>
                                                            </ul>
                                                        </div>
                                                        <div class="product-hover-action d-none">
                                                            <ul>
                                                                <li>
                                                                    <a href="#" title="Quick View" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
                                                                        <i class="far fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                                                        <i class="fas fa-shopping-cart"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" title="Wishlist" data-bs-toggle="modal" data-bs-target="#liton_wishlist_modal">
                                                                        <i class="far fa-heart"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-info">
                                                        {{-- <div class="product-ratting d-none">
                                                            <ul>
                                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                                                <li><a href="#"><i class="far fa-star"></i></a></li>
                                                            </ul>
                                                        </div> --}}
                                                        <h2 class="product-title"><a href="{{ route('web.product', ['id' => $product->id]) }}">{{ $product->title }}</a></h2>
                                                        <div class="product-price">
                                                            <span>£{{ $product->price }}</span>
                                                            <del>{{ $product->cut_price ? '£'.$product->cut_price : NULL }}</del>
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
                    </div>
                    {{-- <div class="ltn__pagination-area text-center">
                        <div class="ltn__pagination">
                            <ul>
                                <li><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
                                <li><a href="#">1</a></li>
                                <li class="active"><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">...</a></li>
                                <li><a href="#">10</a></li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i></a></li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
                <div class="col-lg-4  mb-120 d-none">
                    <aside class="sidebar ltn__shop-sidebar ltn__right-sidebar">
                        <!-- Category Widget -->
                        <div class="widget ltn__menu-widget">
                            <h4 class="ltn__widget-title ltn__widget-title-border">Product categories</h4>
                            <ul>
                                <li><a href="portfolio-details.html">Hand Sanitizer <span><i class="fas fa-long-arrow-alt-right"></i></span></a></li>
                                <li><a href="portfolio-details.html">Lab N95 Face Mask <span><i class="fas fa-long-arrow-alt-right"></i></span></a></li>
                                <li><a href="portfolio-details.html">Hand Gloves <span><i class="fas fa-long-arrow-alt-right"></i></span></a></li>
                                <li><a href="portfolio-details.html">Medical Equipment <span><i class="fas fa-long-arrow-alt-right"></i></span></a></li>
                                <li><a href="portfolio-details.html">New Arrival Product <span><i class="fas fa-long-arrow-alt-right"></i></span></a></li>
                                <li><a href="portfolio-details.html">Uncategorized <span><i class="fas fa-long-arrow-alt-right"></i></span></a></li>
                                <li><a href="portfolio-details.html">Special Offers <span><i class="fas fa-long-arrow-alt-right"></i></span></a></li>
                            </ul>
                        </div>
                        <!-- Banner Widget -->
                        <div class="widget ltn__banner-widget d-none">
                            <a href="shop.html"><img src="img/banner/banner-2.jpg" alt="#"></a>
                        </div>

                    </aside>
                </div>
            </div>
        </div>
    </div>
    <!-- PRODUCT DETAILS AREA END -->

    <!-- FAQ AREA START (faq-2) (ID > accordion_2) -->
<div class="ltn__faq-area pt-115 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area ltn__section-title-2 text-center">
                    <h1 class="section-title white-color---">What are Tablets for Sleeping?</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__faq-inner ltn__faq-inner-2">
                    <div id="accordion_2">
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-1" aria-expanded="true">
                            Diabetes
                            </h6>
                            <div id="faq-item-2-1" class="collapse show" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Type 2 diabetes is a metabolic condition that affects people of all ages more frequently. In the UK, up to one-third of persons are at risk of developing diabetes due to prediabetes. It is brought about by the interaction of our genes and our way of life.
                                        <br>
                                        Being overweight, eating poorly, and not exercising all increase the risk of having diabetes. Early detection of diabetes is crucial because, even if your blood sugar has risen and you are at the prediabetic stage, you can still lower it by changing your lifestyle. Once you have been diagnosed with diabetes, it is crucial to carefully control your blood glucose levels in order to prevent many of the serious complications that can harm your nerves, blood vessels, kidneys, and eyes..
                                        <br>
                                        Diabetes is a key contributor to shortened life expectancy and is a known risk factor for cancer, cardiovascular disease, and other illnesses.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-2" aria-expanded="false">
                            HbA1c
                            </h6>
                            <div id="faq-item-2-2" class="collapse " data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Glycated haemoglobin, commonly known as haemoglobin A1c (HbA1c), is a longer-term indicator of blood glucose levels than a straightforward blood glucose test.
                                        <br>
                                        Your red blood cells' ability to attach glucose to haemoglobin plus the fact that these cells have an average lifespan of 12 to 16 weeks give us a decent idea of the typical quantity of sugar in your blood over the course of three months.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FAQ AREA START -->


@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce
