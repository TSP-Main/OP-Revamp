@extends('web.layouts.default')
@section('title', 'Search')
@section('content')

<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image "  data-bs-bg="img/bg/14.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title">Search Result for {{$string}}</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li>Search Result</li>
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
            <div class="col-lg-12">
                <div class="ltn__shop-options">
                    <ul>
                        <li>
                           <div class="showing-product-number text-right">
                                <span>Showing {{$currentPage}} of {{$total}} results</span>
                            </div> 
                        </li>
                    </ul>
                </div>
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
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
<!-- PRODUCT DETAILS AREA END -->

@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce