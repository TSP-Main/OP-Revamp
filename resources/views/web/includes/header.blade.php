<style>
    .custom-link:hover {
        text-decoration: underline;
    }

    .link-container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }
</style>
<!-- Body main wrapper start -->
<header class="body-wrapper">

    <!-- HEADER AREA START (header-3) -->
    <header class="ltn__header-area ltn__header-3 section-bg-6---">
        <!-- ltn__header-top-area start -->
        <div class="ltn__header-top-area border-bottom top-area-color-white---">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ltn__top-bar-menu text-center">
                            <ul>
                                <li><a href="#" class="text-white font-weight-400  poppins-thin "><i
                                            class="fas fa-comment-medical" class="text-white"></i>Dispensed by Regulated
                                        UK Pharmacists</a></li>
                                <li><a href="#" class="text-white  poppins-thin "><i class="far fa-certificate"
                                                                                     class="text-white font-weight-400"></i>
                                        Registered Pharmacy: 9011972</a></li>
                                <li class="#"><a href="#" class="text-white  pl-2 poppins-regular"> Social Media
                                        Link:</a> <a href="https://www.facebook.com/Online-Pharmacy4U-114908691196467"
                                                     class="top-social-links"><i class="fab fa-facebook-f"></i></a> <a
                                        href="https://twitter.com/4uPharmacy" class="top-social-links"><i
                                            class="fab fa-twitter"></i></a> <a
                                        href="https://www.linkedin.com/company/74292944" class="top-social-links"><i
                                            class="fab fa-linkedin-in"></i></a> <a
                                        href="https://www.tiktok.com/@online.pharmacy4u" class="top-social-links"><i
                                            class="fab fa-tiktok"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ltn__header-top-area end -->
        <!-- ltn__header-middle-area start -->
        <div class="ltn__header-middle-area">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="site-logo">
                            <a class="web-logo" href="/"><img src="{{ asset('img/main-logo.webp') }}" width="100px"
                                                              alt="Logo"></a>
                            <a class="mobile-logo" href="/"><img src="{{ asset('img/mobile-logo.png') }}" width="100px"
                                                                 alt="Logo"></a>
                        </div>
                    </div>
                    <div class="col header-contact-serarch-column d-none d-xl-block">
                        <div class="header-contact-search">
                            <!-- header-feature-item -->
                            <div class="header-feature-item d-none">
                                <div class="header-feature-icon">
                                    <i class="icon-phone"></i>
                                </div>
                                <div class="header-feature-info">
                                    <h6 class=" poppins-thin">Phone</h6>
                                    <p><a href="tel:0123456789">+0123-456-789</a></p>
                                </div>
                            </div>
                            <!-- header-search-2 -->
                            <div class="header-search-2">
                                <form method="get" action="{{route('web.search')}}">
                                    <input type="text" name="q" value="{{ Request('q')}}" placeholder="Search here..."/>
                                    <button type="submit">
                                        <span><i class="icon-search"></i></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <!-- header-options -->
                        <div class="ltn__header-options justify-content-end">
                            <ul>
                                <li class="d-none--- ">
                                    <!-- header-search-1 -->
                                    <div class="header-search-wrap d-block d-xl-none">
                                        <div class="header-search-1">
                                            <div class="search-icon">
                                                <i class="icon-search  for-search-show"></i>
                                                <i class="icon-cancel  for-search-close"></i>
                                            </div>
                                        </div>
                                        <div class="header-search-1-form">
                                            <form method="get" action="{{route('web.search')}}">
                                                <input class=" poppins-thin " type="text" name="q" value=""
                                                       placeholder="Search here..."/>
                                                <button type="submit">
                                                    <span><i class="icon-search"></i></span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-none---">
                                    <!-- user-menu -->
                                    <div class="ltn__drop-menu user-menu">
                                        <ul>
                                            <li>
                                                <a href="#" class=" poppins-thin "><i class="icon-user"></i></a>
                                                <ul>
                                                    @if(auth()->user())
                                                        <li><a href="{{ route('admin.index') }}">My Account</a></li>
                                                        <li><a href="{{ route('web.logout') }}">Sign Out</a></li>
                                                    @else
                                                        <li><a href="{{ route('sign_in_form') }}">Sign in</a></li>
                                                        <li><a href="/register">Register</a></li>
                                                    @endif
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <!-- mini-cart 2 -->
                                    <div class="mini-cart-icon mini-cart-icon-2">
                                        <a href="#ltn__utilize-cart-menu" class="ltn__utilize-toggle">
                                            <span class="mini-cart-icon poppins-thin">
                                                <i class="icon-shopping-cart"></i>
                                                <sup>{{ Cart::count() ?? 0}}</sup>
                                            </span>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                            <div class="d-flex logo-container">
                                <a class="new-logo" href="/">
                                    <img src="{{ asset('img/newlogo.png') }}" width="100px" alt="Logo">
                                </a>
                    <       </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ltn__header-middle-area end -->


        <style>
            @media (max-width: 768px) {
                .ltnheader-options {
                    display: flex;
                    flex-wrap: wrap;
                }

                .ltnheader-options ul {
                    flex: 1 1 auto;
                    order: 0;
                }

                .logo-container {
                    flex-basis: 100%;
                    order: 1;
                    text-align: center;
                    margin-top: 10px;
                }
            }
            .mobile-res-secton {
                display: none !important;
            }

            .navbar {
                /* background-color: #333; */
                overflow: hidden;
                border: 1px solid #b8acac;
                max-width: 90%;
                margin: 0 auto;
                border-radius: 50px;
                display: flex;
                justify-content: space-between;
                padding: 0 !important;
            }

            .search-container {
                position: relative;
                max-width: 85%;
                margin: 0 auto;
            }

            .search-container button {
                position: absolute;
                right: 14px;
                top: 9px;
                font-size: 16px;
            }

            .mobile-res-secton input[type="text"] {
                width: 100%;
                padding: 0px 0px 0px 0px;
                border: 1px solid #ccc;
                border-radius: 4px;
                padding: 12px;
                box-sizing: border-box;
                height: 46px;
                margin: 0 !important;
                position: relative;
                border-radius: 50px;
                font-weight: 300;
                color: #000;
                opacity: 1;
            }

            .navbar a {
                float: left;
                display: block;
                color: gray;
                text-align: center;
                padding: 14px 20px;
                text-decoration: none;
                font-size: 18px;
            }

            .icon {
                display: none;
            }

            .menu {
                width: 0;
                height: 100%;
                position: fixed;
                top: 0;
                left: -34px;
                background-color: #577BBF;
                overflow-x: hidden;
                transition: width 0.5s ease;
                padding-top: 60px;
            }

            .menu a {
                /* padding: 10px; */
                text-decoration: none;
                font-size: 18px;
                color: #fff;
                display: block;
                margin-right: 25px;
                padding: 10px;
            }

            .menu a span {
                justify-content: space-between;
                display: flex;
                align-items: center;
                font-size: 16px;
            }

            .menu a:hover {
                background-color: #1AA7C0;
                color: #fff;
                border-radius: 30px;
            }

            .ltn__social-media-2 a {
                padding: 0 !important;
            }

            .menu.show {
                width: 290px;
                box-shadow: 5px 0px 15px 5px gray;
                left: 0px;
                overflow-y: scroll;
            }


            .submenu {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                transform: translateX(-100%);
                /* Initially off-screen to the left */
                background-color: #4D72B7;
                width: 260px;
                /* Set initial width */
                padding-top: 60px;
                transition: transform 0.5s ease, width 0.5s ease;
                /* Transition transform and width */
                transition-delay: 0.5s;
                /* Delay transition */
                height: 100%;
            }

            .submenu.show {
                display: block;
                transform: translateX(0);
                /* Move into view from the left */
                width: 260px;
                /* Adjust width to desired size */
                box-shadow: 5px 0px 15px 5px #babbca;
                z-index: 99;
                overflow-y: scroll;
            }

            .header-search-1-form button[type="submit"] {
                top: -5px !important;
            }

            .search-open.header-search-1-form {
                height: 45px !important;
                border-radius: 30px;
            }


            .submenu.show a {
                color: #fff;
                font-size: 16px;
            }

            .submenu .closebtn {
                padding: 10px;
                text-decoration: none;
                font-size: 18px;
                color: white;
                display: block;
                text-align: right;
            }

            .subchild {
                padding-left: 20px;
                display: none;
            }

            .subchild.show {
                display: block;
            }

            .icon i {
                display: none;
            }

            .plus-minus-icon i {
                margin-right: 5px;
                font-size: 11px;
            }

            .plus-icon:before {
                content: "\f054";
                color: #fff;
            }

            .minus-icon:before {
                content: "\f107";
            }

            .main-mobile-res {
                display: flex;
                justify-content: space-between;
                margin-bottom: 15px;
            }

            .mobile-logo-icon ul li {
                list-style: none;
                padding: 0 10px;
            }

            .mobile-logo-icon ul {
                display: flex;
                padding: 0 15px;
            }

            #myNavbar .mobile {
                display: none;
            }

            .ltn__social-media-2 ul li a {
                background-color: var(--section-bg-1);
                color: var(--ltn__paragraph-color);
                display: block;
                width: 34px !important;
                height: 34px !important;
                line-height: 35px !important;
                text-align: center;
                margin-right: 10px;
            }

            .ltn__utilize-buttons .utilize-btn-icon {
                width: 42px !important;
                display: inline-block;
                height: 42px !important;
                border: 2px solid var(--border-color-1);
                line-height: 43px !important;
                text-align: center;
                margin-right: 10px;
            }

            .custom-spec a {
                padding: 0px 14px !important;
                margin: 8px 0;
            }


            @media only screen and (max-width: 500px) {
                .mobile-res-secton {
                    display: block !important;
                }

                .icon i {
                    display: block !important;
                }

                #myNavbar .mobile {
                    display: none;
                }
            }

            .menu-item {
                display: flex;
                align-items: center;
                padding: 10px 0; /* Adjust padding as needed */
            }

            .menu-item img {
                margin-right: 10px;
                vertical-align: middle;
            }

            .menu-item a {
                background: none !important;
                font-weight: 600;
                text-align: left;
                text-decoration: none;
            }

            .menu-item a.child-link {
                font-size: 12px;
                font-weight: 500;
            }

            .mega-menu {
                list-style-type: none;
                padding: 0;
                margin: 0;
            }

            .mega-menu > li {
                margin-bottom: 10px; /* Adjust margin as needed */
            }

            .mega-menu > li > ul {
                list-style-type: none;
                padding: 0;
                margin: 0;
                margin-left: 20px; /* Adjust margin as needed */
            }

            @media (max-width: 991px) and (min-width: 501px) {
                .header-search-column, .header-menu-column {
                    display: block;
                }
            }

            body {
                overflow-x: hidden;
            }
        </style>

        <!-- MOBILE MENU START -->
        <div class="mobile-res-secton" style="background: #b2e0eb !important; padding: 10px;">
            <div class="mobile-bav-here">
                <div class="navbar" id="myNavbar">
                    <a href="#" class="active">Home</a>
                    <a href="#" class="mobile">About</a>
                    <a href="#" class="mobile">Services</a>
                    <a href="#" class="mobile">Contact</a>
                    <a href="javascript:void(0);" class="icon" onclick="toggleMenu()">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
            </div>

            <div class="menu px-3 py-4" id="myMenu">
                <a href="#" class="closebtn mb-2" onclick="toggleMenu()"><i class="fa fa-times" aria-hidden="true"></i>
                    Back</a>
                <div class="search-container">
                    <form method="get" action="{{route('web.search')}}">
                        <input type="text" name="q" value="{{ Request('q')}}" placeholder="Search...">
                        <button type="submit" style="background:transparent;"><i class="icon-search"></i></button>
                    </form>
                </div>
                @foreach ($menu_categories as $key => $val)
                    <div class="custom-spec"
                         style="display: flex !important; justify-content: space-between;align-items: center; padding:5px 10px;">
                        <a href="{{ route('web.collections', ['main_category' => $val['slug']]) }}">
                            <span class="plus-minus-icon">{{ $val['name'] }}</span>
                        </a>
                        @if($val['subcategory'])
                            <i class="fa plus-icon" onclick="toggleSubMenu({{++$key}})"></i>
                        @endif
                    </div>

                    <div class="submenu" id="mySubMenu{{$key}}">
                        <a href="#" class="closebtn" onclick="toggleSubMenu({{$key}})"><i class="fa fa-times"
                                                                                          aria-hidden="true"></i>
                            Back</a>
                        @foreach($val['subcategory'] as $key1 => $val1)
                            <div
                                style="display: flex !important; justify-content: space-between;align-items: center; padding:5px 10px;">
                                <a href="{{ route('web.collections', ['main_category' => $val['slug'],'sub_category' => $val1['slug']]) }}">
                                    <span class="plus-minus-icon">{{ $val1['name'] }}</span>
                                </a>
                                @if($val1['child_categories'])
                                    <i class="fa plus-icon" onclick="toggleSubChild({{$key}}, {{++$key1}})"></i>
                                @endif
                            </div>
                            <div class="subchild" id="subChild{{$key}}_{{$key1}}">
                                @foreach($val1['child_categories'] as $key2 => $val2)
                                    <a href="{{ route('category.products', ['main_category' => $val['slug'],'sub_category' => $val1['slug'], 'child_category' => $val2['slug']]) }}">{{ $val2['name'] }}</a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <div class="ltn__utilize-buttons ltn__utilize-buttons-2">
                    <ul>

                        <li>
                            <a title="My Account" href="{{ route('web.index') }}">
                                <span class="utilize-btn-icon">
                                    <i class="far fa-user"></i>
                                </span>
                                My Account
                            </a>
                        </li>
                        <li>
                            <a href="{{route('web.view.cart')}}" title="Shoping Cart">
                                <span class="utilize-btn-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                    <sup>{{ Cart::count() ?? 0}}</sup>
                                </span>
                                Shoping Cart
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="ltn__social-media-2">
                    <ul>
                        <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                        <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>


        </div>
        <!-- MOBILE MENU END -->
        <!-- header-bottom-area start -->
        <div
            class="header-bottom-area ltn__border-top--- ltn__header-sticky  ltn__sticky-bg-white ltn__primary-bg---- menu-color-white---- d-none--- d-lg-block">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col--- header-menu-column justify-content-center---">
                            <div class="header-menu header-menu-2 text-start">
                                <nav>
                                    <div class="ltn__main-menu text-center">
                                        <ul>
                                            <li><a style="background: none !important;" href="/" class="poppins-thin">Home</a>
                                            </li>
{{--                                            @dd($menu_categories);--}}
                                            @foreach ($menu_categories as $key => $val)

                                                <li class="menu-item">
                                                    <a href="{{ route('web.collections', ['main_category' => $val['slug']]) }}">{{ $val['name'] }}</a>
                                                    <ul class="mega-menu">
                                                        @foreach($val['subcategory'] as $key1 => $val1)
                                                            @php
                                                                $path_sub_icon = asset('img/online-pharmacy.png');
                                                                if($val1['icon'] ?? NULL){
                                                                $path_sub_icon = asset('storage/'.$val1['icon']);
                                                                }
                                                            @endphp
                                                            <li>
                                                                <div class="link-container">
                                                                    <a class="custom-link"
                                                                       href="{{ route('web.collections', ['main_category' => $val['slug'],'sub_category' => $val1['slug']]) }}">
                                                                        <img src="{{ $path_sub_icon }}" height="27"
                                                                             width="27">{{ $val1['name'] }}
                                                                    </a>
                                                                </div>
                                                                <ul>
                                                                    @foreach($val1['child_categories'] as $key2 => $val2)
                                                                        @php
                                                                            $path_child_icon = asset('img/drug.png');
                                                                            if($val2['icon'] ?? NULL){
                                                                            $path_child_icon = asset('storage/'.$val2['icon']);
                                                                            }
                                                                        @endphp
                                                                        <li class="menu-item">
                                                                            <img src="{{ $path_child_icon }}"
                                                                                 height="27" width="27">
                                                                            <a class="custom-link child-link"
                                                                               href="{{ route('category.products', ['main_category' => $val['slug'],'sub_category' => $val1['slug'], 'child_category' => $val2['slug']]) }}">{{ $val2['name'] }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach

                                            <li><a style="background: none !important;" href="{{ route('web.work') }}"
                                                   class="poppins-thin">How it work's</a></li>
                                            <li><a style="background: none !important;" href="/help"
                                                   class="poppins-thin">Help</a></li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- header-bottom-area end -->

            <div class="ltn__header-bottom-area border-bottom top-area-color-white---  d-none">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="ltn__top-bar-menu">
                                <ul>
                                    <li><a href="#" class="text-white font-weight-400"><i
                                                class="fas fa-plus"></i><strong class="font-bold">Regulated</strong>
                                            Pharmacy </a></li>
                                    <li><a href="#" class="text-white"><i class="fas fa-box"></i><span
                                                class="text-black"><strong class="font-bold">Discreet</strong> Packaging </span></a>
                                    </li>
                                    <li><a href="#" class="text-white"><i class="fas fa-truck"></i><span
                                                class="text-black"> <strong class="font-bold">Free Delivery</strong> on orders over £40* </span></a>
                                    </li>
                                    <li><a href="#" class="text-white">Excellent<i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i
                                                class="fas fa-star-half"></i><strong>4.4</strong> based on
                                            <strong>1,421</strong> reviews</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER AREA END -->

    <!-- Utilize Cart Menu Start -->
    <div id="ltn__utilize-cart-menu" class="ltn__utilize ltn__utilize-cart-menu">
        <div class="ltn__utilize-menu-inner ltn__scrollbar">
            <div class="ltn__utilize-menu-head">
                <span class="ltn__utilize-menu-title">Cart</span>
                <button class="ltn__utilize-close">×</button>
            </div>
            <div class="mini-cart-product-area ltn__scrollbar">
                @if(!empty(Cart::content()))
                    @foreach(Cart::content() as $item)
                        <div class="mini-cart-item clearfix">
                            <div class="mini-cart-img">
                                <a href="#"><img src="{{ asset('storage/'.$item->options->productImage)}}" alt="Image"></a>
                                <span class="mini-cart-item-delete"><a href="javascript:void(0)"
                                                                       onclick="deleteItem('{{$item->rowId}}', true);"><i
                                            class="icon-cancel"></i></a></span>
                            </div>
                            <div class="mini-cart-info">
                                <h6>
                                    <a href="#">{!! $item->name !!} {!! $item->options->variant_info ? $item->options->variant_info->new_var_info : '' !!} </a>
                                </h6>
                                <span class="mini-cart-quantity">{{ $item->qty }} x {{ $item->price}}</span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="mini-cart-footer">
                <div class="mini-cart-sub-total">
                    <h5>Subtotal: <span class="mini-cart-subtotal">£{{ Cart::subTotal() }}</span></h5>
                </div>
                <div class="btn-wrapper">
                    <a href="/cart" class="theme-btn-1 btn btn-effect-1">View Cart</a>
                    <a href="/checkout" class="theme-btn-2 btn btn-effect-2">Checkout</a>
                </div>
                {{-- <p>Free Shipping on All Orders Over $100!</p> --}}
            </div>

        </div>
    </div>
    <!-- Utilize Cart Menu End -->


    <script>
        function toggleMenu() {
            document.getElementById("myMenu").classList.toggle("show");
        }

        function toggleSubMenu(submenuNumber) {
            var submenuId = "mySubMenu" + submenuNumber;
            var allSubmenus = document.getElementsByClassName("submenu");
            for (var i = 0; i < allSubmenus.length; i++) {
                if (allSubmenus[i].id === submenuId) {
                    allSubmenus[i].classList.toggle("show");

                } else {
                    allSubmenus[i].classList.remove("show");

                }
            }
        }

        function toggleSubChild(submenuNumber, subchildNumber) {
            var subchildId = "subChild" + submenuNumber + "_" + subchildNumber;
            var subchild = document.getElementById(subchildId);
            subchild.classList.toggle("show");
        }
    </script>

    <div class="ltn__header-bottom-area border-bottom top-area-color-white---  d-none">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ltn__top-bar-menu">
                        <ul>
                            <li><a href="#" class="text-white font-weight-400"><i class="fas fa-plus"></i><strong
                                        class="font-bold">Regulated</strong> Pharmacy </a></li>
                            <li><a href="#" class="text-white"><i class="fas fa-box"></i><span
                                        class="text-black"><strong class="font-bold">Discreet</strong> Packaging </span></a>
                            </li>
                            <li><a href="#" class="text-white"><i class="fas fa-truck"></i><span
                                        class="text-black"> <strong class="font-bold">Free Delivery</strong> on orders over £40* </span></a>
                            </li>
                            <li><a href="#" class="text-white">Excellent<i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star-half"></i><strong>4.4</strong> based on
                                    <strong>1,421</strong> reviews</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </header>
    <!-- HEADER AREA END -->

    <!-- Utilize Cart Menu Start -->
    <div id="ltn__utilize-cart-menu" class="ltn__utilize ltn__utilize-cart-menu">
        <div class="ltn__utilize-menu-inner ltn__scrollbar">
            <div class="ltn__utilize-menu-head">
                <span class="ltn__utilize-menu-title">Cart</span>
                <button class="ltn__utilize-close">×</button>
            </div>
            <div class="mini-cart-product-area ltn__scrollbar">
                @if(!empty(Cart::content()))
                    @foreach(Cart::content() as $item)
                        <div class="mini-cart-item clearfix">
                            <div class="mini-cart-img">
                                <a href="#"><img src="{{ asset('storage/'.$item->options->productImage)}}" alt="Image"></a>
                                <span class="mini-cart-item-delete"><a href="javascript:void(0)"
                                                                       onclick="deleteItem('{{$item->rowId}}', true);"><i
                                            class="icon-cancel"></i></a></span>
                            </div>
                            <div class="mini-cart-info">
                                <h6>
                                    <a href="#">{!! $item->name !!} {!! $item->options->variant_info ? $item->options->variant_info->new_var_info : '' !!} </a>
                                </h6>
                                <span class="mini-cart-quantity">{{ $item->qty }} x {{ $item->price}}</span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="mini-cart-footer">
                <div class="mini-cart-sub-total">
                    <h5>Subtotal: <span class="mini-cart-subtotal">£{{ Cart::subTotal() }}</span></h5>
                </div>
                <div class="btn-wrapper">
                    <a href="/cart" class="theme-btn-1 btn btn-effect-1">View Cart</a>
                    <a href="/checkout" class="theme-btn-2 btn btn-effect-2">Checkout</a>
                </div>
                {{-- <p>Free Shipping on All Orders Over $100!</p> --}}
            </div>

        </div>
    </div>
    <!-- Utilize Cart Menu End -->


    <script>
        function toggleMenu() {
            document.getElementById("myMenu").classList.toggle("show");
        }

        function toggleSubMenu(submenuNumber) {
            var submenuId = "mySubMenu" + submenuNumber;
            var allSubmenus = document.getElementsByClassName("submenu");
            for (var i = 0; i < allSubmenus.length; i++) {
                if (allSubmenus[i].id === submenuId) {
                    allSubmenus[i].classList.toggle("show");

                } else {
                    allSubmenus[i].classList.remove("show");

                }
            }
        }

        function toggleSubChild(submenuNumber, subchildNumber) {
            var subchildId = "subChild" + submenuNumber + "_" + subchildNumber;
            var subchild = document.getElementById(subchildId);
            subchild.classList.toggle("show");
        }
    </script>
