@extends('web.layouts.default')
@section('title', 'Category')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="ltn__utilize-overlay"></div>
<style>
   .card {
    position: relative;
    border: 2px solid #ddd;
    border-radius: 10px;
    box-shadow: 4px 4px 4px rgba(62, 224, 207, 0.5); 
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 4px px rgb(62, 224, 207); 
}


.card-body {
    padding: 20px;
    text-align: center;
}

.product-price {
    font-weight: bold;
    font-size: 1.2em;
    color: #333;
}
</style>
<!-- clinic online -->
<section class="clinic-main">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <div class="erctile-img">
                    <img src="{{ asset('storage/'.$category_detail->image)}}" alt="{{ $category_detail->name ?? '' }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="erectile-content">
                    <h2>{{ $category_detail->name }}</h2>
                    <p>{!! $category_detail->desc !!}</p>
                    @if($product_ids && $pre_add_to_cart == 'no')
                    @if($pre_add_to_cart == 'no')
                    <form id="start_consultation_from" action="{{ route('web.consultationForm') }}" method="POST">
                        @csrf
                        <input type="hidden" name="template" value="{{ config('constants.PRESCRIPTION_MEDICINE') }}">
                        <input type="hidden" name="product_id" value="{{$product_ids}}">
                    </form>
                    @endif

                    <button form="start_consultation_from" type="submit" class="btn btn-primary my-3 btn-large">Start {{ $category_detail->name }} Consultation</button>
                    <button form="start_consultation_from" type="submit" class="btn btn-primary my-3 small-btn">Start Consultation </button>
                    @endif
                    <a href="#products_list" class="btn btn-outline-danger view-btn">View Treatments </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="products_list" class="treatment my-5 py-5">
    <div class="container">
        <h4 class="text-center pb-4">{{ $category_detail->name }}</h4>
        <div class="row">
            @foreach($products as $key => $val)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('web.product', ['id' => $val->slug]) }}">
                            <h5 class="card-title">{{$val->title}}</h5>
                            <img src="{{ asset('storage/'.$val->main_image)}}" class="card-img-top mb-2" alt="...">
                        </a>
                        <div class="product-price">
                            <span>£{{ $val->price }}</span>
                            <del>{{ $val->cut_price ? '£'.$val->cut_price : NULL }}</del>
                        </div>
                        @if($val->stock_status == 'IN')
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
                        @else
                        <a class="btn btn-secondary disabled" title="Out of Stock" aria-disabled="true">
                            <i class="fas fa-exclamation-circle"></i>
                            <span> Out of Stock</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div style="display: flex; justify-content: center; margin-top:20px">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
</section>

<section class="explain my-5 py-5">
    <div class="container">
        <h4 class="text-center pt-4 pb-5">Easy Steps for your Medicine</h4>
        <div class="row">
            <div class="col-md-4">
                <div class="explain-step text-center">
                    <img src="/img/product/ban-1.png" width="220px" alt="...">
                    <h4 class="mt-2 mb-0 ">Complete a consultation.</h4>
                    <p>With complete privacy and confidentiality your form is checked by a pharmacist independent prescriber.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="explain-step text-center d-block">
                    <img src="/img/product/ban-2.png" width="220px" alt="...">
                    <h4 class="mt-2 mb-0">Choose your treatment.</h4>
                    <p>From the list approved by the prescriber, choose your preferred treatment and then wait for it to be dispensed by UK Meds online pharmacy.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="explain-step text-center">
                    <img src="/img/product/ban-3.png" width="220px" alt="...">
                    <h4 class="mt-2 mb-0">Receive your delivery.</h4>
                    <p>With next day delivery options available, you can have your treatment sent out to you discreetly within hours.</p>
                </div>
            </div>
        </div>
        @if($product_ids && $pre_add_to_cart == 'no')
        @if($pre_add_to_cart == 'no')
        <div class="import-btn text-center mt-4">
            <button form="start_consultation_from" type="submit" class="btn btn-danger large-scr">Start {{ $category_detail->name }} Consultation</button>
            <button form="start_consultation_from" type="submit" class="btn btn-primary my-3 small-btn">Start Consultation </button>
        </div>
        <div class="small-scr">
            <button form="start_consultation_from" type="submit" class="btn btn-danger start">Start consultation</button>
        </div>
        @endif @endif
    </div>
</section>


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

</script>
@endPushOnce