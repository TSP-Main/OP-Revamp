@extends('web.layouts.default')
@section('title', 'Collection')
@section('content')
<style>
    .description {
        max-height: 5.6em;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;
        display: -webkit-box;
        line-height: 1.4em;
    }
</style>
<!-- BREADCRUMB AREA START -->
<section class="clinic-main">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <div class="erctile-img">
                    <img src="{{ asset('storage/'.$image) }}" alt="{{ $category_name}}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="erectile-content">
                    <h2>{{ $category_name}}</h2>
                    <p class="{{($category_desc == '') ? 'my-5' : 'mb-2' }}">{{$category_desc ?? ''}}</p>
                    <a href="#products_list" class="btn btn-outline-danger view-btn">View Treatments </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BREADCRUMB AREA END -->

<!-- Categories AREA START -->
<div class="ltn__team-area pt-110--- pb-90">
    <div class="container">
        <div class="row justify-content-center">
            @foreach ($categories as $key => $val)
            <div class="col-lg-4 col-sm-6 mt-5">
                <div class="ltn__team-item ltn__team-item-3---">
                    <div class="team-img">
                        <img src="{{ asset('storage/'.$val['image']) }}" alt="Image">
                    </div>
                    <div class="team-info">
                        <h4><a href="{{ route('web.collections', ['main_category' => $main_slug,'sub_category' => isset($sub_slug) ? $sub_slug : $val['slug']]) }}">{{ $val['name'] }}</a></h4>
                        <p class="description">{{ $val['desc'] }}</p>
                    </div>
                    <div class="team-info">
                        <a href="{{ route('category.products', ['main_category' => $main_slug,'sub_category' => isset($sub_slug) ? $sub_slug : $val['slug'], 'child_category' => isset($sub_slug) ? $val['slug'] : NULL]) }}" class="btn theme-btn-1">View Products</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Categories AREA END -->

@if (isset($products) && $products)
<!-- PRODUCT DETAILS AREA START -->
<div id="products_list" class="ltn__product-area ltn__product-gutter mb-120">
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
                                <form action="{{ route('web.collections', [
                                    'main_category' => request()->route('main_category'),
                                    'sub_category' => request()->route('sub_category')
                                    ]) }}" method="GET">
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
                                            <a href="{{ route('web.product', ['id' => $val->slug]) }}"><img src="{{ asset('storage/'.$val->main_image)}}" alt="product image"></a>
                                            <div class="product-hover-action">
                                                <ul>
                                                    @if($val->stock_status == 'IN')
                                                    @if($val->product_template == config('constants.COUNTER_MEDICINE'))
                                                    <li>
                                                        <a href="{{ route('web.product', ['id' => $val->slug]) }}">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
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
                                                    @else
                                                    <a class="btn btn-secondary disabled" title="Out of Stock" aria-disabled="true">
                                                        <i class="fas fa-exclamation-circle"></i>
                                                    </a>
                                                    @endif
                                                    {{-- <li>
                                                            <a href="#" title="Wishlist" data-bs-toggle="modal" data-bs-target="#liton_wishlist_modal">
                                                                <i class="far fa-heart"></i></a>
                                                        </li> --}}
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
                            @foreach($categories as $key => $val)
                            @if ($is_product)
                            <li><a href="{{ route('category.products', ['main_category' => $main_slug,'sub_category' => isset($sub_slug) ? $sub_slug : $val['slug'], 'child_category' => isset($sub_slug) ? $val['slug'] : NULL]) }}">{{$val['name']}} <span><i class="fas fa-long-arrow-alt-right"></i></span></a></li>
                            @else
                            <li><a href="{{ route('web.collections', ['main_category' => $main_slug,'sub_category' => isset($sub_slug) ? $sub_slug : $val['slug']]) }}">{{$val['name']}} <span><i class="fas fa-long-arrow-alt-right"></i></span></a></li>
                            @endif
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
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- PRODUCT DETAILS AREA END -->
@endif

@stop

@pushOnce('scripts')
<script>
    $(document).ready(function() {
        $(document).delegate(".qtybutton", "click", function(e) {
            var quantity = $('.cart-plus-minus-box').val();
            $('#quantity_input').val(quantity);
        });

        $('.add-to-cart-form').on('submit', function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var url = $(this).attr('action');

            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                success: function(response) {
                    $('#add_to_cart_modal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endPushOnce