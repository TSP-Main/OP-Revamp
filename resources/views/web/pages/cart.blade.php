@extends('web.layouts.default')
@section('title', 'Cart')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- BREADCRUMB AREA START -->
    <div class="ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image "  data-bs-bg="img/bg/14.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__breadcrumb-inner">
                        <h1 class="page-title">Cart</h1>
                        <div class="ltn__breadcrumb-list">
                            <ul>
                                <li><a href="/"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                                <li>Cart</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->

    <!-- SHOPPING CART AREA START -->
    <div class="liton__shoping-cart-area mb-120">
        <div class="container">
            <div class="row">
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{Session::get('success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="col-lg-12">
                    @if(!empty($cartContent))
                        <div class="shoping-cart-inner">
                            <div class="shoping-cart-table table-responsive">
                                <table class="table">
                                    <thead>
                                        <th class="cart-product-remove">Remove</th>
                                        <th class="cart-product-image">Image</th>
                                        <th class="cart-product-info">Product</th>
                                        <th class="cart-product-price">Price</th>
                                        <th class="cart-product-quantity">Quantity</th>
                                        <th class="cart-product-subtotal">Subtotal</th>
                                    </thead>
                                    <tbody>
                                        @foreach($cartContent as $item)
                                        <tr>
                                            <td class="cart-product-remove"><a href="javascript:void(0)" onclick="deleteItem('{{ $item->rowId }}', false);">x</a></td>
                                            <td class="cart-product-image">
                                                <a href="{{ route('web.product', ['id' => $item->options->slug]) }}"><img src="{{ asset('storage/'.$item->options->productImage) }}" alt="#"></a>
                                            </td>
                                            <td class="cart-product-info">
                                                <h6><a href="{{ route('web.product', ['id' => $item->options->slug]) }}">{!! $item->name !!} {!! $item->options->variant_info ? $item->options->variant_info->new_var_info : '' !!}</a></h6>
                                            </td>
                                            <td class="cart-product-price">£{{ $item->price}}</td>
                                            <td class="cart-product-quantity" data-id="{{ $item->rowId }}">
                                                @if($item->options->high_risk == "2" || ($item->options->max_buy !== null && $item->qty >= $item->options->max_buy))
                                                    <span>{{ $item->qty }}</span> <!-- Just show the quantity for high-risk products or if buy limit reached -->
                                                @else
                                                    <div class="cart-plus-minus">
                                                        <input type="text" value="{{ $item->qty }}" name="qtybutton" class="cart-plus-minus-box">
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="cart-product-subtotal">£{{ $item->price * $item->qty }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="shoping-cart-total mt-50">
                                <h4>Cart Totals</h4>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Cart Subtotal</td>
                                            <td class="cart-subtotal">£{{ Cart::subTotal() }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Order Total</strong></td>
                                            <td class="cart-total"><strong>£{{ Cart::subTotal() }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="btn-wrapper text-right">
                                    <a href="{{ route('web.checkout') }}" class="theme-btn-1 btn btn-effect-1">Proceed to checkout</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- SHOPPING CART AREA END -->

@stop

@pushOnce('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).delegate(".qtybutton", "click", function(e) {
        var rowId = $(this).closest('tr').find('.cart-product-quantity').data('id');
        var quantity = parseFloat($(this).closest('tr').find('.cart-plus-minus-box').val());
        updateCart(rowId, quantity);
    });

    function updateCart(rowId, qty){
        $.ajax({
            url: '{{ route("web.cart.update") }}',
            type: 'post',
            data: {rowId:rowId, qty:qty},
            dataType: 'json',
            success: function(response){
                if(response.status == true){
                    window.location.href = "{{ route('web.view.cart') }}";
                }
            }
        });
    }
</script>
@endPushOnce
