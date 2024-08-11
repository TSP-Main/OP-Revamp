@extends('web.layouts.default')
@section('title', 'Conditions')
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
                    <h1 class="page-title">Search Conditions A-Z</h1>
                    <p>No matter what ails you, Online Pharmacy 4U is here to offer assistance. We have a wide range of treatments available for various common illnesses. You can be assured of high quality medicine dispensed by a licensed UK pharmacist. Transactions are safe and 100% secured.</p>
                    <br>
                    <p>Can't find what you're looking for?</p>
                    <a href="{{ route('web.treatment')}}" class="btn btn-outline-danger view-btn">Try Our Treatments A-Z </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->
<div class="choose">
    <ul>
        <li><strong>Choose</strong> </li>
        <li class="{{$range == 'a-e' ? 'active' : ''}}"><a href="{{ route('web.conditions', ['t' => 'a-e'])}} ">A-E</a></li>
        <li class="{{$range == 'f-j' ? 'active' : ''}}"><a href="{{ route('web.conditions', ['t' => 'f-j'])}} ">F-J</a></li>
        <li class="{{$range == 'k-o' ? 'active' : ''}}"><a href="{{ route('web.conditions', ['t' => 'k-o'])}} ">K-O</a></li>
        <li class="{{$range == 'p-t' ? 'active' : ''}}"><a href="{{ route('web.conditions', ['t' => 'p-t'])}} ">P-T</a></li>
        <li class="{{$range == 'u-z' ? 'active' : ''}}"><a href="{{ route('web.conditions', ['t' => 'u-z'])}} ">U-Z</a></li>
    </ul>
</div>

<!-- Categories AREA START -->
<div class="ltn__team-area pt-110--- pb-90">
    <div class="container">
        <div class="row justify-content-center">
            @foreach ($conditions as $key => $val)
                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__team-item ltn__team-item-3---">
                        <div class="team-img">
                            <img src="{{ asset('storage/'.$val['image']) }}" alt="Image">
                        </div>
                        @php
                            $count = count(explode('/', $val['url']));
                        @endphp
                        @if ($count == 3)
                            <div class="team-info">
                                <h4><a href="/category/{{$val['url']}}">{{ $val['name'] }}</a></h4>
                                <p class="description">{{ $val['desc'] }}</p>
                            </div>
                            <div class="team-info">
                                <a href="/category/{{$val['url']}}" class="btn theme-btn-1">View Products</a>
                            </div>
                        @else
                            <div class="team-info">
                                <h4><a href="/collections/{{$val['url']}}">{{ $val['name'] }}</a></h4>
                                <p class="description">{{ $val['desc'] }}</p>
                            </div>
                            <div class="team-info">
                                <a href="/collections/{{$val['url']}}" class="btn theme-btn-1">View Products</a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Categories AREA END -->

@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce