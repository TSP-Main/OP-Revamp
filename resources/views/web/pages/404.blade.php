@extends('web.layouts.default')
@section('title', 'Page Not Found')
@section('content')

<!-- 404 area start -->
<div class="ltn__404-area ltn__404-area-1 mb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="error-404-inner text-center">
                    <div class="error-img mb-30">
                        <img src="/img/error-1.png" alt="#">
                    </div>
                    <h1 class="error-404-title d-none">404</h1>
                    <h2>Working, Soon to Appear!</h2>
                    <!-- <h3>Oops! Looks like something going rong</h3> -->
                    <p>Oops! The page you are looking for is currently being updated by our team. Please check back shortly.</p>
                    <div class="btn-wrapper">
                        <a href="{{ url()->previous() }}" class="btn btn-transparent"><i class="fas fa-long-arrow-alt-left"></i> BACK</a>
                        <a href="/" class="btn btn-transparent">HOME</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 404 area end -->


@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce
