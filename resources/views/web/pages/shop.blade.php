@extends('web.layouts.default')
@section('title', 'Shop')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image " data-bs-bg="img/bg/14.png">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title">Online Pharmacy 4U Shop</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="#"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li>Online Pharmacy 4U Shop</li>
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
                        <li>
                            <div class="short-by text-center">
                                <form action="{{ route('shop') }}" method="GET">
                                    <select class="nice-select" name="sort" onchange="this.form.submit()">
                                        <option value="">Default Sorting</option>
                                        {{-- <option>Sort by popularity</option> --}}
                                        <option value="newest" {{ Request::get('sort') === 'newest' ? 'selected' : '' }}>Sort by new arrivals</option>
                                        <option value="price_low_high" {{ Request::get('sort') === 'price_low_high' ? 'selected' : '' }}>Sort by price: low to high</option>
                                        <option value="price_high_low" {{ Request::get('sort') === 'price_high_low' ? 'selected' : '' }}>Sort by price: high to low</option>
                                    </select>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="liton_product_grid">
                        <div class="ltn__product-tab-content-inner ltn__product-grid-view">
                            <div class="row">
                                <!-- ltn__product-item -->
                                @foreach($products as $key => $val)
                                <div class="col-xl-4 col-sm-6 col-6">
                                    <div class="ltn__product-item ltn__product-item-3 text-center">
                                        <div class="product-img">
                                            <a href="#"><img src="{{ asset('storage/'.$val->main_image)}}" alt="#"></a>
                                            {{-- <div class="product-badge">
                                                    <ul>
                                                        <li class="sale-badge">New</li>
                                                    </ul>
                                                </div> --}}
                                            <div class="product-hover-action">
                                                <ul>
                                                    @if($val->product_template == config('constants.COUNTER_MEDICINE'))
                                                    <li>
                                                        <a href="{{ route('web.product', ['id' => $val->slug]) }}">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        {{-- <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </a> --}}
                                                        <a href="javascript:void(0)" onclick="addToCart({{ $val->id }});" title="Add to Cart">
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </a>
                                                    </li>
                                                    @else
                                                    <li>
                                                        <a href="#" title="You have to answer some question" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                                            <i class="fas fa-plus"></i>
                                                        </a>
                                                    </li>
                                                    @endif

                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <div class="product-ratting d-none">
                                                <ul>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                                    <li><a href="#"><i class="far fa-star"></i></a></li>
                                                </ul>
                                            </div>
                                            <h2 class="product-title"><a href="{{ route('web.product', ['id' => $val->slug]) }}">{{ $val->title }}</a></h2>
                                            <div class="product-price">
                                                <span>£{{ $val->price }}</span>
                                                <del>{{ $val->cut_price ? '£'.$val->cut_price : NULL }}</del>
                                            </div>
                                            @if($val->product_template == config('constants.COUNTER_MEDICINE'))
                                            <a href="javascript:void(0)" onclick="addToCart(@json($val->id));" title="Add to Cart" class="btn btn-outline-danger w-100">Add To Cart</a>
                                            @else
                                            @if($val->product_template == config('constants.PRESCRIPTION_MEDICINE') && $pre_add_to_cart == 'yes')
                                            <a href="{{ route('web.product', ['id' => $val->slug]) }}" class="btn btn-outline-danger w-100">Select Treatment </a>
                                            @elseif($val->product_template == config('constants.PHARMACY_MEDECINE') && isset(session('consultations')[$val->id]))
                                            <a href="{{ route('web.product', ['id' => $val->slug]) }}" class="btn btn-outline-danger w-100">Select Treatment </a>
                                            @else
                                            <a href="{{ route('web.product', ['id' => $val->slug]) }}" class="btn btn-outline-danger w-100">Learn More</a>
                                            @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <!-- ltn__product-item -->
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end;">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
            <div class="col-lg-4  mb-120">
                <aside class="sidebar ltn__shop-sidebar ltn__right-sidebar">
                    <!-- Category Widget -->
                    <div class="widget ltn__menu-widget">
                        <h4 class="ltn__widget-title ltn__widget-title-border">Product categories</h4>
                        <ul>
                            @foreach($categories_list as $key => $val)
                            <li><a href="{{ route('category.products', ['main_category' => $val->slug]) }}">{{$val->name}} <span><i class="fas fa-long-arrow-alt-right"></i></span></a></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Price Filter Widget -->
                    <div class="widget ltn__price-filter-widget d-none">
                        <h4 class="ltn__widget-title ltn__widget-title-border">Filter by price</h4>
                        <div class="price_filter">
                            <div class="price_slider_amount">
                                <input type="submit" value="Your range:" />
                                <input type="text" class="amount" name="price" placeholder="Add Your Price" />
                            </div>
                            <div class="slider-range"></div>
                        </div>
                    </div>
                    <!-- Top Rated Product Widget -->
                    <div class="widget ltn__top-rated-product-widget d-none">
                        <h4 class="ltn__widget-title ltn__widget-title-border">Top Rated Product</h4>
                        <ul>
                            <li>
                                <div class="top-rated-product-item clearfix">
                                    <div class="top-rated-product-img">
                                        <a href="product-details.html"><img src="img/product/1.png" alt="#"></a>
                                    </div>
                                    <div class="top-rated-product-info">
                                        <div class="product-ratting d-none">
                                            <ul>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                            </ul>
                                        </div>
                                        <h6><a href="product-details.html">Mixel Solid Seat Cover</a></h6>
                                        <div class="product-price">
                                            <span>$49.00</span>
                                            <del>$65.00</del>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="top-rated-product-item clearfix">
                                    <div class="top-rated-product-img">
                                        <a href="product-details.html"><img src="img/product/2.png" alt="#"></a>
                                    </div>
                                    <div class="top-rated-product-info">
                                        <div class="product-ratting d-none">
                                            <ul>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                            </ul>
                                        </div>
                                        <h6><a href="product-details.html">Thermometer Gun</a></h6>
                                        <div class="product-price">
                                            <span>$49.00</span>
                                            <del>$65.00</del>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="top-rated-product-item clearfix">
                                    <div class="top-rated-product-img">
                                        <a href="product-details.html"><img src="img/product/3.png" alt="#"></a>
                                    </div>
                                    <div class="top-rated-product-info">
                                        <div class="product-ratting d-none">
                                            <ul>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                                <li><a href="#"><i class="far fa-star"></i></a></li>
                                            </ul>
                                        </div>
                                        <h6><a href="product-details.html">Coil Spring Conversion</a></h6>
                                        <div class="product-price">
                                            <span>$49.00</span>
                                            <del>$65.00</del>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- Search Widget -->
                    <div class="widget ltn__search-widget d-none">
                        <h4 class="ltn__widget-title ltn__widget-title-border">Search Objects</h4>
                        <form action="#">
                            <input type="text" name="search" placeholder="Search your keyword...">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                    <!-- Tagcloud Widget -->
                    <div class="widget ltn__tagcloud-widget d-none">
                        <h4 class="ltn__widget-title ltn__widget-title-border">Popular Tags</h4>
                        <ul>
                            <li><a href="#">Body</a></li>
                            <li><a href="#">Doctor</a></li>
                            <li><a href="#">Drugs</a></li>
                            <li><a href="#">Eye</a></li>
                            <li><a href="#">Face</a></li>
                            <li><a href="#">Hand</a></li>
                            <li><a href="#">Mask</a></li>
                            <li><a href="#">Medicine</a></li>
                            <li><a href="#">Price</a></li>
                            <li><a href="#">Sanitizer</a></li>
                            <li><a href="#">Virus</a></li>
                        </ul>
                    </div>


                    <!-- Banner Widget -->
                    <!-- <div class="widget ltn__banner-widget">
                        <a href="shop.html"><img src="img/banner/banner-2.jpg" alt="#"></a>
                    </div> -->

                </aside>
            </div>
        </div>
    </div>
</div>
<!-- PRODUCT DETAILS AREA END -->

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
                                    {{-- <div class="modal-product-img">
                                        <img src="img/product/1.png" alt="#">
                                    </div> --}}
                                    <div class="modal-product-info">
                                        <h5><a href="product-details.html"></a></h5>
                                        <p class="added-cart"><i class="fa fa-check-circle"></i> Successfully added to your Cart</p>
                                        <div class="btn-wrapper">
                                            <a href="{{route('web.view.cart')}}" class="theme-btn-1 btn btn-effect-1">View Cart</a>
                                            <a href="{{route('web.checkout')}}" class="theme-btn-2 btn btn-effect-2">Checkout</a>
                                        </div>
                                    </div>
                                    <!-- additional-info -->
                                    <div class="additional-info d-none">
                                        <p>We want to give you <b>10% discount</b> for your first order, <br> Use discount code at checkout</p>
                                        <div class="payment-method">
                                            <img src="img/icons/payment.png" alt="#">
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

@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce