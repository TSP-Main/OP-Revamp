@extends('web.layouts.default')
@section('title', 'Product Detail')
@section('content')
<style>
    .variant_tag {
        font-size: 14px;
        line-height: 1;
        text-transform: capitalize;
        padding: 7px 15px;
        border-radius: 20px;
        border: 1px solid #e6e8eb;
        transition: all 0.4s ease;
        border-color: #21cdc0;
        background-color: #fff;
        color: var(--ltn__heading-color);
    }

    .variant_tag_active {
        font-size: 14px;
        line-height: 1;
        text-transform: capitalize;
        padding: 7px 15px;
        border-radius: 20px;
        border: 1px solid #e6e8eb;
        transition: all 0.4s ease;
        border-color: #21cdc0;
        background-color: #0ab9ad;
        color: #fff;
    }

    .btn.out-of-stock {
        background-color: #6c757d;
        border-color: #6c757d;
        color: #ffffff;
        pointer-events: none;
        cursor: not-allowed;
    }

    .btn.out-of-stock i {
        margin-right: 5px;
    }
    .custom-tooltip {
    background-color: #fc9898; /* Background color */
    color: #fff; /* Text color */
    padding: 10px; /* Padding */
    border-radius: 5px; /* Rounded corners */
}

</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image" data-bs-bg="img/bg/14.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title">Product Details</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li>Product Details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- SHOP DETAILS AREA START -->
<div class="ltn__shop-details-area pb-85">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="ltn__shop-details-inner mb-60">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="ltn__shop-details-img-gallery">
                                <div class="ltn__shop-details-large-img">
                                    <div class="single-large-img">
                                        <a href="{{ asset('storage/'.$product->main_image)}}" data-rel="lightcase:myCollection">
                                            <img class="img-fluid" src="{{ asset('storage/'.$product->main_image)}}" alt="Image" id="product_img">
                                        </a>
                                    </div>
                                </div>

                                <div class="ltn__shop-details-small-img slick-arrow-2">
                                    @foreach($product->variants ?? [] as $key => $val)
                                    <div class="single-small-img variant_img_{{$val->id}}" style="height: 145px !important; width: 145px !important;">
                                        @php
                                        $src = ($val->image) ? $val->image : '';
                                        @endphp
                                        @if($src)
                                        <img class="img-fluid  variant_no_{{$val->id}}" src="{{ asset('storage/'.$src)}}" alt="Image" data-variant_id="{{$val->id ?? ''}}" data-variant_data="{{ json_encode($val) }}" data-main_image="{{ $product->main_image }}">
                                        @endif
                                    </div>
                                    @endforeach
                                    @foreach($product->productAttributes ?? [] as $key => $val1)
                                    <div class="single-small-img }" style="height: 145px !important; width: 145px !important;">
                                        @php
                                        $src = ($val1->image) ? $val1->image : '';
                                        @endphp
                                        @if($src)
                                        <img class="img-fluid  " src="{{ asset('storage/'.$src)}}" alt="Image">
                                        @endif
                                    </div>
                                    @endforeach


                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="modal-product-info shop-details-info pl-0">
                                <div class="product-ratting d-none">
                                    <ul>
                                        <li><a href="#"><i class="fas fa-star"></i></a></li>
                                        <li><a href="#"><i class="fas fa-star"></i></a></li>
                                        <li><a href="#"><i class="fas fa-star"></i></a></li>
                                        <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                        <li><a href="#"><i class="far fa-star"></i></a></li>
                                        <li class="review-total"> <a href="#"> ( 95 Reviews )</a></li>
                                    </ul>
                                </div>
                                <h3>{{ $product->title }}</h3>
                                <div class="product-price">
                                    <span id="product_price">{{ '£'.$product->price }}</span>
                                    <del id="product_cut_price">{{ $product->cut_price ? '£'.$product->cut_price : NULL}}</del>
                                    <input type="hidden" name="variant_id" id="variant_id" value="">
                                </div>
                                <div class="modal-product-meta ltn__product-details-menu-1">
                                    <ul>
                                        <li>
                                            <strong>Categories:</strong>
                                            <span>
                                                <a href="{{ route('category.products', ['main_category' => $product->category->slug]) }}">{{ $product->category->name}}</a>
                                                @if($product->sub_category)
                                                <a href="{{ route('category.products', ['main_category' => $product->category->slug,'sub_category' => $product->sub_cat->slug]) }}">{{ $product->sub_cat->name}}</a>
                                                @endif
                                                @if($product->child_category)
                                                <a href="{{ route('category.products', ['main_category' => $product->category->slug,'sub_category' => $product->sub_cat->slug, 'child_category' => $product->child_cat->slug]) }}">{{ $product->child_cat->name}}</a>
                                                @endif
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                @if($product->high_risk == '2')
                                <a href="{{ $product->leaflet_link }}" target="_blank">
                                    <div class="d-flex align-items-center" style="max-width: 350px; margin-bottom: 20px; font-size: 12px;">
                                    <i class="fas fa-info-circle" style="color: #007bff; margin-right: 8px;  font-size: 20px;"></i>
                                    <span style="font-size: 15px;">Information Leaflet</span>
                                </div> </a>
                                <div class="alert alert-warning" role="alert" style="max-width: 350px; padding: 10px; font-size: 12px;">
                                    <h4 class="alert-heading" style="font-size: 14px;">Product & Safety Notice</h4>
                                    <ul>
                                        <li>The maximum purchase for this product is 1.</li>
                                        <li>3 days use only. This product can cause addiction.</li>
                                        <li>
                                            <a href="https://www.gov.uk/guidance/opioid-medicines-and-the-risk-of-addiction" class="alert-link">Click here</a> for advice.
                                        </li>
                                    </ul>
                                </div>
                                @endif
                                <div class="ltn__product-details-menu-2">
                                    <ul>
                                        <li>
                                            @if(true)
                                                @if($product->high_risk == 2)
                                                    <input type="hidden" id="quantity-input" value="1" name="qtybutton">
                                                @else
                                                    <div class="cart-plus-minus">
                                                        <input type="text" value="1" name="qtybutton" class="cart-plus-minus-box" id="quantity-input">
                                                    </div>
                                                @endif
                                            @else
                                                <!-- Hide the quantity counter -->
                                                <div style="display: none;">
                                                    <input type="text" value="1" name="qtybutton" class="cart-plus-minus-box" id="quantity-input">
                                                </div>
                                            @endif
                                        </li>
                                        <li>
                                            @php
                                                $cartItems = Cart::content();
                                                $hasHighRiskProduct = $cartItems->contains(function ($item) {
                                                    return $item->options->high_risk == 2;
                                                });
                                                $highRiskProductNames = $cartItems->filter(function ($item) {
                                                    return $item->options->high_risk == 2;
                                                })->pluck('name')->toArray();

                                                $tooltipMessage = "Adding multiple high-risk medications to your cart is not permitted. ";
                                                if (!empty($highRiskProductNames)) {
                                                    $tooltipMessage .= "Currently in cart: " . implode(", ", $highRiskProductNames);
                                                }
                                            @endphp

                                            @if(true)
                                                @if($product->high_risk == 2 && $hasHighRiskProduct)
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="tooltip"
                                                            data-bs-title="{{ $tooltipMessage }}"
                                                            data-bs-html="true">
                                                        <i class="fas fa-exclamation-circle"></i> Unavailable
                                                    </button>
                                                    <a href='/medicine-restriction-policy' style='color: blue;' target='_blank'>Learn more</a>
                                                @else
                                                    @if($product->product_template == config('constants.PRESCRIPTION_MEDICINE') && $pre_add_to_cart == 'yes')
                                                        <a href="javascript:void(0)" onclick="addToCart(@json($product->id));" class="theme-btn-1 btn btn-effect-1" title="Add to Cart">
                                                            <i class="fas fa-shopping-cart"></i>
                                                            <span>ADD TO CART</span>
                                                        </a>
                                                    @elseif($product->product_template == config('constants.PHARMACY_MEDECINE') && isset(session('consultations')[$product->id]))
                                                        <a href="javascript:void(0)" onclick="addToCart(@json($product->id));" class="theme-btn-1 btn btn-effect-1" title="Add to Cart">
                                                            <i class="fas fa-shopping-cart"></i>
                                                            <span>ADD TO CART</span>
                                                        </a>
                                                        @elseif( $product->product_template == 1 && $product->question_risk == "2")
                                                        <form action="{{ route('web.consultationForm') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="template" value="{{ config('constants.PHARMACY_MEDECINE') }}">
                                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                            <input type="hidden" name="question_risk" value="{{ $product->question_risk }}">
                                                            <button type="submit" class="theme-btn-1 btn btn-effect-1" title="Start Consultation">
                                                                <span>Start Consultation</span>
                                                            </button>
                                                        </form>
                                                    @elseif($product->product_template == 1)
                                                        <form action="{{ route('web.consultationForm') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="template" value="{{ config('constants.PHARMACY_MEDECINE') }}">
                                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                            <input type="hidden" name="question_risk" value="{{ $product->question_risk }}">
                                                            <button type="submit" class="theme-btn-1 btn btn-effect-1" title="Start Consultation">
                                                                <span>Start Consultation</span>
                                                            </button>
                                                        </form>
                                                    @elseif ($product->product_template == 2)
                                                        <form action="{{ route('category.products', ['main_category' => $product->category->slug ?? NULL, 'sub_category' => $product->sub_cat->slug ?? NULL, 'child_category' => $product->child_cat->slug ?? NULL]) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                            <button type="submit" class="theme-btn-1 btn btn-effect-1" title="Start Consultation">
                                                                <span>Start Consultation</span>
                                                            </button>
                                                        </form>
                                                    @elseif ($product->product_template == 3)
                                                        <a href="javascript:void(0)" onclick="addToCart({{ $product->id }});" class="theme-btn-1 btn btn-effect-1" title="Add to Cart">
                                                            <i class="fas fa-shopping-cart"></i>
                                                            <span>ADD TO CART</span>
                                                        </a>
                                                    @endif
                                                @endif
                                                @else
                                                <!-- Notify Me Button -->
                                                <form action="{{ route('notify.me', $product->id) }}" method="POST" class="d-inline-block" id="notify-form-{{ $product->id }}">
                                                    @csrf

                                                    <!-- Check if the user is logged in or not -->
                                                    @if(auth()->check())
                                                        <!-- If logged in, show the email as readonly, pre-filled with the user's email -->
                                                        <input type="email" name="email" value="{{ auth()->user()->email }}" readonly required>
                                                    @else
                                                        <!-- If not logged in, provide an empty field for the user to enter their email -->
                                                        <input type="email" name="email" placeholder="Enter your email" required>
                                                    @endif

                                                    <i class="fas fa-exclamation-circle"></i>
                                                    <span>Out of Stock</span> <br>
                                                    
                                                    <!-- Button to trigger the form submission -->
                                                    <button type="button" class="theme-btn-1 btn btn-effect-1" title="Notify Me" onclick="notifyMe({{ auth()->check() ? 'true' : 'false' }}, '{{ route('notify.me', $product->id) }}')">
                                                        <span>Notify When in Stock</span>
                                                    </button>
                                                </form>


                                                {{-- <a class="btn btn-secondary disabled" title="Out of Stock" aria-disabled="true">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    <span>Out of Stock</span>
                                                </a> --}}
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <div id="out-of-stock-message" style="display:none;">
                                    <form action="{{ route('notify.me', $product->id) }}" method="POST" class="d-inline-block" id="notify-form-{{ $product->id }}">
                                        @csrf

                                        <!-- Check if the user is logged in or not -->
                                        @if(auth()->check())
                                            <!-- If logged in, show the email as readonly, pre-filled with the user's email -->
                                            <input type="email" name="email" value="{{ auth()->user()->email }}" readonly required>
                                        @else
                                            <!-- If not logged in, provide an empty field for the user to enter their email -->
                                            <input type="email" name="email" placeholder="Enter your email" required>
                                        @endif

                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>Out of Stock</span> <br>
                                        
                                        <!-- Button to trigger the form submission -->
                                        <button type="button" class="theme-btn-1 btn btn-effect-1" title="Notify Me" onclick="notifyMe({{ auth()->check() ? 'true' : 'false' }}, '{{ route('notify.me', $product->id) }}')">
                                            <span>Notify When in Stock</span>
                                        </button>
                                    </form>
                                </div>
                                <div class="ltn__product-details-menu-3 ">
                                    <ul>
                                        @if(!$product['variants']->isEmpty())
                                        <li>
                                            <div style="padding: 20px;" class="widget widget-tags">
                                                @foreach($varints_selectors as $key => $selector)
                                                <h5 class="widget__title" style="margin-bottom: 1px !important; margin-top: 20px;"><span id="product_title">{{ $selector ?? ''}} :</span></h5>
                                                <div class="widget-content">
                                                    <ul class="list-unstyled">
                                                        @if(isset($variants_tags[$selector]))
                                                        @foreach($variants_tags[$selector] as $key => $vrr)
                                                        <li style="cursor: pointer;">
                                                            <a class="variants @if($loop->first) variant_tag_active @else variant_tag @endif selector_{{ str_replace(' ', '_', $selector) }}" data-selector="selector_{{ str_replace(' ', '_', $selector) }}" data-variant_val="{{$vrr}}" data-main_image="{{ $product->main_image }}">
                                                                {{ $vrr }}
                                                            </a>
                                                        </li>
                                                        @endforeach
                                                        @endif
                                                    </ul>
                                                </div>
                                                @endforeach
                                            </div>
                                        </li>
                                        @endif
                                        <li class="d-none">
                                            <a href="#" class="" title="Wishlist" data-bs-toggle="modal" data-bs-target="#liton_wishlist_modal">
                                                <i class="far fa-heart"></i>
                                                <span>Add to Wishlist</span>
                                            </a>
                                        </li>
                                        <li class="d-none">
                                            <a href="#" class="" title="Compare" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
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
                                        <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                                        <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>

                                    </ul>
                                </div>
                                <hr>
                                <div class="ltn__safe-checkout d-none">
                                    <h5>Guaranteed Safe Checkout</h5>
                                    <img src="img/icons/payment-2.png" alt="Payment Image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" ltn__shop-details-tab-inner ltn__shop-details-tab-inner-2">
                    <div class="ltn__shop-details-tab-menu">
                        <div class="nav">
                            <a class="active show" data-bs-toggle="tab" href="#liton_tab_details_1_1">Description</a>
                            @if($faqs)
                            <a data-bs-toggle="tab" href="#liton_tab_details_1_2" class="">FAQ's</a>
                            @endif
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="liton_tab_details_1_1">
                            <div class="ltn__shop-details-tab-content-inner">
                                <h4 class="title-2">{{ $product->title }}</h4>
                                <p>{!! $product->desc !!}</p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="liton_tab_details_1_2">
                            <div class="accordion mt-2" id="accordionPanelsStayOpenExample">
                                @foreach($faqs ?? [] as $key => $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-heading{{$faq['id']}}">
                                        <button class="accordion-button{{ $loop->first ? '' : ' collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{$faq['id']}}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="panelsStayOpen-collapse{{$faq['id']}}">
                                            Q. {{ ++$key}} {{ $faq['title'] }}
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapse{{$faq['id']}}" class="accordion-collapse collapse{{ $loop->first ? ' show' : '' }}" aria-labelledby="panelsStayOpen-heading{{$faq['id']}}">
                                        <div class="accordion-body">
                                            {!! $faq['desc'] !!}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- SHOP DETAILS AREA END -->

<!-- PRODUCT SLIDER AREA START -->
<div class="ltn__product-slider-area ltn__product-gutter pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area ltn__section-title-2">
                    <h4 class="title-2">Related Products<span>.</span></h1>
                </div>
            </div>
        </div>
        <div class="row ltn__related-product-slider-one-active slick-arrow-1">
            <!-- ltn__product-item -->
            @foreach ($related_products as $related_product)
            <div class="col-lg-12">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="{{ route('web.product', ['id' => $related_product->slug]) }}"><img src="{{ asset('storage/'.$related_product->main_image) }}" alt="image"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <h2 class="product-title"><a href="{{ route('web.product', ['id' => $related_product->slug]) }}">{{ $related_product->title }}</a></h2>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- PRODUCT SLIDER AREA END -->
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
  // Function to handle variant updates
   // Function to handle variant updates
function updateVariant() {
    var variantData = @json($variants ?? []);  // Variant data passed from backend
    var variant_selector = $(this).data('selector'); // Use data attribute

    // Escape special characters if necessary (but avoid direct use in selectors)
    var escapedSelector = variant_selector.replace(/([:#.,?+\*&\^%$@!])/g, '\\$1');

    // Update the classes for the variant selector
    $('[data-selector="'+escapedSelector+'"]').removeClass('variant_tag_active').addClass('variant_tag');
    $(this).removeClass('variant_tag').addClass('variant_tag_active');

    var combinedVariantVal = '';
    $('.variant_tag_active').each(function() {
        var variantValue = $(this).data('variant_val');
        variantValue = String(variantValue).replace(/;/g, '').replace(/ /g, '_');
        combinedVariantVal += variantValue;
    });

    var current_variant = variantData[combinedVariantVal];

    // Update URL with variant information
    var current_variant_slug = current_variant.slug;
    var currentUrl = window.location.href;
    var newUrl = updateUrlParameter(currentUrl, 'variant', current_variant_slug);
    history.pushState({}, '', newUrl);

    // Update the product image and price
    var mainImage = $(this).data('main_image');
    var image_src = "{{ asset('storage/') }}";
    $('#variant_id').val(current_variant.id);

    if (current_variant.image) {
        $('#product_img').attr('src', image_src + '/' + current_variant.image);
    } else {
        $('#product_img').attr('src', image_src + '/' + mainImage);
    }

    $('#product_price').text('£ ' + current_variant.price);

    if (current_variant.cut_price) {
        $('#product_cut_price').text('£ ' + current_variant.cut_price);
    } else {
        $('#product_cut_price').text('');
    }

    // Update quantity limits
    $('#min_buy').val(current_variant.min_buy || 1);
    $('#max_buy').val(current_variant.max_buy || 999);

    // Check if the selected variant is out of stock
    if (current_variant.stock_status == 'OUT') {
        // Show out of stock message for variants
        $('.ltn__product-details-menu-2').hide();
        $('#out-of-stock-message').show();
        $('#quantity-input').prop('disabled', true);  // Disable quantity input
        $('#add-to-cart-button').prop('disabled', true);  // Disable add-to-cart button
    } else {
        // If variant is in stock, show the normal menu and enable buttons
        $('.ltn__product-details-menu-2').show();
        $('#out-of-stock-message').hide();
        $('#quantity-input').prop('disabled', false);
        $('#add-to-cart-button').prop('disabled', false);
    }
}

    // Trigger variant update on click
    $(document).on('click', '.variants', updateVariant);

    // Call the update function on page load for the default active variant
    var activeVariant = $('.variants.variant_tag_active').first();
    if (activeVariant.length) {
        updateVariant.call(activeVariant);
    }

    // Validate quantity input for minimum and maximum limits
    $(document).on('input', '.cart-plus-minus-box', function() {
        var minBuy = parseInt($('#min_buy').val());
        var maxBuy = parseInt($('#max_buy').val());
        var qty = parseInt($(this).val());

        if (qty < minBuy) {
            alert('Minimum quantity is ' + minBuy);
            $(this).val(minBuy);
        } else if (qty > maxBuy) {
            alert('Maximum quantity is ' + maxBuy);
            $(this).val(maxBuy);
        }
    });

    // Function to update URL parameters
    function updateUrlParameter(url, key, value) {
        var urlParts = url.split('?');
        if (urlParts.length >= 2) {
            var prefix = encodeURIComponent(key) + '=';
            var params = urlParts[1].split(/[&;]/g);

            for (var i = 0; i < params.length; i++) {
                if (params[i].startsWith(prefix)) {
                    params[i] = prefix + encodeURIComponent(value);
                    return urlParts[0] + '?' + params.join('&');
                }
            }
            url += '&' + prefix + encodeURIComponent(value);
        } else {
            url += '?' + encodeURIComponent(key) + '=' + encodeURIComponent(value);
        }
        return url;
    }

    // Initialize tooltip functionality
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip({
            trigger: 'manual' // Prevents tooltip from hiding automatically
        }).on('mouseenter', function() {
            // Show tooltip on mouse enter
            $(this).tooltip('show');
        }).on('mouseleave', function() {
            // Hide tooltip on mouse leave, but only if not clicked
            if (!$(this).data('clicked')) {
                $(this).tooltip('hide');
            }
        }).on('click', function() {
            // Prevent tooltip from hiding when clicked
            $(this).data('clicked', true);
        });
    });

  // Function for "Notify Me" functionality
    function notifyMe(isLoggedIn, actionUrl) {
        // if (!isLoggedIn) {
        //     // Redirect to login if not logged in
        //     window.location.href = '/sign-in';
        //     return;
        // }

        // If logged in, submit the notification form
        document.getElementById('notify-form-' + actionUrl.split('/').pop()).submit();
    }

</script>

@endPushOnce
