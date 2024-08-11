<!doctype html>
<html class="no-js" lang="eng">

<head>
    @include('web.includes.head')
    <title>@yield('title' , 'Online Pharmacy 4U')</title>
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T99GH5S3" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Body main wrapper end -->
    <div class="body-wrapper">
        @include('web.includes.header', ['menu_categories' => $menu_categories])
        @include('web.includes.menu')
        <div class="ltn__utilize-overlay"></div>
        @yield('content')
        @include('web.includes.footer')
    </div>
    <!-- Body main wrapper end -->

    <!-- preloader area start -->
    <div class="preloader d-none" id="preloader">
        <div class="preloader-inner">
            <div class="spinner">
                <div class="dot1"></div>
                <div class="dot2"></div>
            </div>
        </div>
    </div>
    <!-- preloader area end -->

    @include('web.includes.script')
    @stack('scripts')
</body>

</html>