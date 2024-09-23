@extends('web.layouts.default')
@section('title', 'Treatment')
@section('content')
<style>
    .choose ul{
        display: flex;
        justify-content: center;
        margin: 0;
        padding: 10px 0;
    }
    .choose ul li{
        list-style: none;
        margin: 0 5px;
        padding: 5px 8px;
        font-size: 18px;
    }
    .choose ul li.active {
        border: #ddd 1px solid;
        border-radius: 5px;
    }
</style>

<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image margin"  data-bs-bg="img/bg/14.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title">Search Treatments A-Z</h1>
                    <p>No matter what ails you, Online Pharmacy 4U is here to offer assistance. We have a wide range of treatments available for various common illnesses. You can be assured of high quality medicine dispensed by a licensed UK pharmacist. Transactions are safe and 100% secured.</p>
                    <br>
                    <p>Can't find what you're looking for?</p>
                    <a href="{{ route('web.conditions')}}" class="btn btn-outline-danger view-btn">Try Our Conditions A-Z </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->
<div class="choose">
    <ul>
        <li><strong>Choose</strong> </li>
        <li class="{{$range == 'a-e' ? 'active' : ''}}"><a href="{{ route('web.treatment', ['t' => 'a-e'])}} ">A-E</a></li>
        <li class="{{$range == 'f-j' ? 'active' : ''}}"><a href="{{ route('web.treatment', ['t' => 'f-j'])}} ">F-J</a></li>
        <li class="{{$range == 'k-o' ? 'active' : ''}}"><a href="{{ route('web.treatment', ['t' => 'k-o'])}} ">K-O</a></li>
        <li class="{{$range == 'p-t' ? 'active' : ''}}"><a href="{{ route('web.treatment', ['t' => 'p-t'])}} ">P-T</a></li>
        <li class="{{$range == 'u-z' ? 'active' : ''}}"><a href="{{ route('web.treatment', ['t' => 'u-z'])}} ">U-Z</a></li>
    </ul>
</div>

<!-- PRODUCT DETAILS AREA START -->
<div class="ltn__product-area ltn__product-gutter mb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="liton_product_grid">
                        <div class="ltn__product-tab-content-inner ltn__product-grid-view">
                            <div class="row">
                                <!-- ltn__product-item -->
                                @if (count($products) > 0)
                                    @foreach ($products as $key => $val)
                                        <div class="col-xl-3 col-lg-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="{{ route('web.product', ['id' => $val->slug]) }}"><img src="{{ asset('storage/'.$val->main_image)}}" alt="#"></a>
                                                </div>
                                                <div class="product-info">
                                                    <h2 class="product-title"><a href="{{ route('web.product', ['id' => $val->slug]) }}">{{ $val->title }}</a></h2>
                                                    <div class="product-price">
                                                        <span>£{{ $val->price }}</span>
                                                        <del>{{ $val->cut_price ? '£'.$val->cut_price : NULL }}</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    No Result Found
                                @endif
                                <!--  -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="display: flex; justify-content: center;">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
<!-- PRODUCT DETAILS AREA END -->


@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce