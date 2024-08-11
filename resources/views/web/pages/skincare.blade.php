@extends('web.layouts.default')
@section('title', 'Skin Care')
@section('content')


<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-image " data-bs-bg="img/banner/skincare.png">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title mt-5">Skin Care</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li>Skin Care</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- ABOUT US AREA START -->
<div class="ltn__about-us-area pt-25--- pb-120 ">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="about-us-img-wrap about-img-left">
                    <img src="img/product/skincare_1.webp" alt="About Us Image">
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="about-us-info-wrap">
                    <div class="section-title-area ltn__section-title-2--- mb-30">
                        <h1 class="section-title">In what order should I apply my skincare products?</h1>
                        <p>Regardless of whether your skincare routine contains two products or ten, it’s important to apply them in the right order so they work as they should.<br>
                        First things first, use your cleanser to wash your face before applying any other products, morning or night.
                        <br>If you’re using a toner, apply that next, followed by a serum and then your moisturiser.
                        <br> 
                        For your daytime routine, make sure you finish off your skincare routine by applying sunscreen if your moisturiser doesn’t contain a high SPF.
                    </p>
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- ABOUT US AREA END -->

<div class="container pb-25">
    <div class="row m-2 mb-30">
        <!-- Card 1 -->
        @if($products)
            @foreach($products as $product)
                <div class="col-md-3">
                    <div class="card">
                        <img src="{{asset('storage/'.$product->main_image)}}" class="card-img-top" alt="Card Image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->title }}</h5>
                            <p><strong>{{ '£'.$product->price }}</strong></p>
                            <a href="{{ route('web.product', ['id' => $product->id]) }}" class="btn theme-btn-1">View Product</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<!-- ABOUT US AREA START -->
<div class="container-fluid mt-3 "  style="background: #def3f8;">
    <div class="ltn__about-us-area pt-5 mt-170 pb-50 ">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="about-us-info-wrap">
                        <div class="section-title-area ltn__section-title-2--- mb-30">
                            <h6 class="section-subtitle section-subtitle-2 ltn__secondary-color d-none">About Us</h6>
                            <h5 class="section-title">Prescription Strength Acne Treatments</h5>
                            <p>Acne is a common problem, particularly during puberty because of the changes in hormone levels.</p>
                            <p>If you find that your acne just isn’t going away, you may need to try a few methods and treatments to fix the problem.</p>
                            <p>Sometimes though, home remedies or over-the-counter acne treatments aren’t effective enough to treat moderate or severe acne.</p>
                            <p>That’s why we offer a range of prescription-strength treatments for acne including Duac Once Daily Gel, Differin Creme, Dalacin T Lotion and many more.</p>
                            <p>All you’ll need to do is complete a short online consultation with one of our prescribers to see if there’s a suitable treatment for you.</p>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="about-us-img-wrap about-img-left">
                        <img src="img/banner/prescription-strength-treatment_1__1.webp" style="border-radius: 20px;" alt="About Us Image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ABOUT US AREA END -->

<!-- FAQ AREA START (faq-2) (ID > accordion_2) -->
<div class="ltn__faq-area pt-115 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area ltn__section-title-2 text-center">
                    <!-- <h1 class="section-title white-color---">Some Questions</h1> -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__faq-inner ltn__faq-inner-2">
                    <div id="accordion_2">
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-1" aria-expanded="true">
                            What does toner do for skin?
                            </h6>
                            <div id="faq-item-2-1" class="collapse show" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Toners are designed to be used after your cleanser, to remove any remaining dirt, make-up or impurities that may have been left behind. Anyone can use a toner, but they’re definitely beneficial for people with oily or acne-prone skin, or those who wear a lot of make-up. Toner can also improve the tightness of your pores, skin tone, and smoothness.</p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-2" aria-expanded="false">
                            How do exfoliators work?
                            </h6>
                            <div id="faq-item-2-2" class="collapse " data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Exfoliation is the process of removing dead skin cells, either physically or chemically. Physical exfoliants, like a facial scrub or exfoliating mitt, work by manually removing dead skin with a rough surface. Chemical exfoliants, as the name suggests, use chemicals to break the bonds between skin cells and remove dead skin. Examples of chemical exfoliants include alpha hydroxy acids (AHAs), such as glycolic acid, and beta hydroxy acids (BHAs) such as salicylic acid.</p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-3" aria-expanded="false">
                            When should I use moisturiser?
                            </h6>
                            <div id="faq-item-2-3" class="collapse" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Moisturisers are one of the most essential components of a skincare routine, but when is the best time to use them? Always use a moisturiser after cleansing or washing your face for a boost of hydration that will prevent your skin from drying out. Generally, using a moisturiser once in the morning (along with SPF!) and once in the evening is a good benchmark.</p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-4" aria-expanded="false">
                            What skincare products do I need?
                            </h6>
                            <div id="faq-item-2-4" class="collapse" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>With so many skincare products on the market, it can be difficult to know which ones you actually need for your skincare routine. Building a basic skincare routine starts with a cleanser, a daytime moisturiser with SPF and a night time moisturiser. If you want to enhance your skincare routine you could opt for toners, serums, exfoliators and eye creams. There are plenty of options available for different skin types, from dry or oily to eczema-prone or sensitive.</p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-5" aria-expanded="false">
                            What do eye creams do?
                            </h6>
                            <div id="faq-item-2-5" class="collapse" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Eye creams are designed to reduce the appearance of fine lines, wrinkles, puffiness and dark circles. <br><b>But what’s the difference between an eye cream and a normal moisturiser? </b><br>The difference is that eye creams are specially formulated to hydrate the delicate skin around your eyes, whereas moisturisers are designed for your skin as a whole and might not be suitable for use around the eyes.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none">
                <aside class="about-us-img-wrap about-img-right">
                    <img src="img/allbanners/faq600x600.png" alt="Banner Image">
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- FAQ AREA START -->

@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce