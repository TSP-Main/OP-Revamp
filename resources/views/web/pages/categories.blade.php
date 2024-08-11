@extends('web.layouts.default')
@section('title', 'Categories')
@section('content')

<style>
    /* Custom card styles */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s;
    }

    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-img-top {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        max-height: 200px;
        object-fit: cover;
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .card-text {
        font-size: 1rem;
        color: #555;
    }

    .btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 15px;
        padding: 10px;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #0056b3;
        color: #fff;
    }
</style>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image " data-bs-bg="img/allbanners/about.png">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title mt-5">shop by collection</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li>categories</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<div class="container">
    <div class="row m-2 mb-30">
        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Card Image">
                <div class="card-body">
                    <h5 class="card-title">Card Title 1</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="/categorydetail" class="btn">View Product</a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Card Image">
                <div class="card-body">
                    <h5 class="card-title">Card Title 2</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="/categorydetail" class="btn">View Product</a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Card Image">
                <div class="card-body">
                    <h5 class="card-title">Card Title 3</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="/categorydetail" class="btn">View Product</a>
                </div>
            </div>
        </div>

    </div>
    <div class="row m-2 mb-30">
        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Card Image">
                <div class="card-body">
                    <h5 class="card-title">Card Title 1</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="/categorydetail" class="btn">View Product</a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Card Image">
                <div class="card-body">
                    <h5 class="card-title">Card Title 2</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="/categorydetail" class="btn">View Product</a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Card Image">
                <div class="card-body">
                    <h5 class="card-title">Card Title 3</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="/categorydetail" class="btn">View Product</a>
                </div>
            </div>
        </div>

    </div>
    <div class="row m-2 mb-30">
        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Card Image">
                <div class="card-body">
                    <h5 class="card-title">Card Title 1</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="/categorydetail" class="btn">View Product</a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Card Image">
                <div class="card-body">
                    <h5 class="card-title">Card Title 2</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="/categorydetail" class="btn">View Product</a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Card Image">
                <div class="card-body">
                    <h5 class="card-title">Card Title 3</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="/categorydetail" class="btn">View Product</a>
                </div>
            </div>
        </div>

    </div>
</div>
   <!-- BANNER AREA START -->
   <div class="ltn__banner-area " style="margin-top: 50px;">
    <div class="container">
        <div class="row ltn__custom-gutter--- justify-content-center">
            <div class="col-lg-4 col-sm-6">
                <div class="ltn__banner-item">
                    <div class="ltn__banner-img">
                        <a href="#"><img src="img/banner/new_banner2_1.webp" alt="Banner Image" class="image-radius"></a>
                    </div>
                </div>
                <h4 class="text-center">Select your medication.</h4>
                <p class="text-center">Simply select the medication you wish to purchase by searching for it directly or by browsing the categories using the top navigation bar. It's easy!</p>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="ltn__banner-item">
                    <div class="ltn__banner-img">
                        <a href="#"><img src="img/banner/new_banner3_1.webp" alt="Banner Image" class="image-radius"></a>
                    </div>
                </div>
                <h4 class="text-center">Quick 60 secs FREE consultation.</h4>
                <p class="text-center">Once you have selected your medication, you will need to complete a FREE 1-minute consultation. Our panel of GPhC approved prescribers will check your consultation and once approved, your prescription will be dispensed by Online Pharmacy4U.</p>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="ltn__banner-item">
                    <div class="ltn__banner-img">
                        <a href="#"><img src="img/banner/new_banner4_1.webp" alt="Banner Image" calss="image-radius"></a>
                    </div>
                </div>
                <h4 class="text-center">Receive your Express delivery</h4>
                <p class="text-center">With our next-day delivery option, you can have your medications delivered to your door within hours in discreet packaging.</p>
            </div>
        </div>
    </div>
</div>
<!-- BANNER AREA END -->



@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce