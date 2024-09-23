@extends('web.layouts.default')
@section('title', 'faq')
@section('content')


    <!-- BREADCRUMB AREA START -->
    <div class="ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image "  data-bs-bg="img/allbanners/about.png">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__breadcrumb-inner">
                        <h1 class="page-title mt-5">Frequently Asked Question</h1>
                        <div class="ltn__breadcrumb-list">
                            <ul>
                                <li><a href="/"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                                <li>Frequently Asked Question</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->



    
    <!-- FAQ AREA START (faq-2) (ID > accordion_2) -->
    <div class="ltn__faq-area pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2 text-center">
                        <h1 class="section-title white-color---">Some Questions</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="ltn__faq-inner ltn__faq-inner-2">
                        <div id="accordion_2">
                            <!-- card -->
                            <div class="card">
                                <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-1" aria-expanded="false">
                                How long does delivery take?
                                </h6>
                                <div id="faq-item-2-1" class="collapse show" data-bs-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>Delivery times vary depending on the option you select in the checkout. We provide free delivery with the Royal Mail monitored 48 deliveries which could take 3-4 days, or you could opt to pay a bit extra to get your order delivered in 1-2 days. We also provide a faster delivery option where the delivery can reach to you as early as 9am on the next day. The delivery times are subject to the cut off time and be impacted by weekends and bank holidays. The delivery times can also depend on when your order is approved by the prescriber.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- card -->
                            <div class="card">
                                <h6 class="ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-2" aria-expanded="false"> 
                                Do you ship outside the UK?
                                </h6>
                                <div id="faq-item-2-2" class="collapse " data-bs-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>Unfortunately, we cannot send any medical products outside of the United Kingdom because of the legal limitations and good practise. The limitation applies across the website as we take guidance from our regulators regarding the license in the destination country.</p>
                                    </div>
                                </div>
                            </div>                          
                            <!-- card -->
                            <div class="card">
                                <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-3" aria-expanded="false">
                                Are you a provider of controlled drugs?
                                </h6>
                                <div id="faq-item-2-3" class="collapse" data-bs-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>Yes, we can supply Controlled Drugs. The February 2019 changes to Controlled Drugs legislation mean that Controlled Drugs may now be sent electronically via the Electronic Prescription Service. This means that there is no need to send us a paper prescription. Signed delivery is required for Controlled Drugs. Please get in touch if you have any Controlled Drugs.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- card -->
                            <div class="card">
                                <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-4" aria-expanded="false">
                                Can you deliver my insulin?
                                </h6>
                                <div id="faq-item-2-4" class="collapse" data-bs-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>Yes, we ship insulin in refrigerated packages on 24 hour tracked delivery. This ensures that your medication is kept at the right temperature during transit.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- card -->
                            <div class="card">
                                <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-5" aria-expanded="false">
                                How do I make a complaint?
                                </h6>
                                <div id="faq-item-2-5" class="collapse" data-bs-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>To make a complaint please email us on help@online-pharmacy4u.co.uk. You can also use our contact form to write to us, please be as much informative as possible to make sure your complaint is resolved as quickly as possible.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-11" aria-expanded="false">
                                How does your service work?
                                </h6>
                                <div id="faq-item-2-11" class="collapse" data-bs-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>Our service is a convenient and safe way to have medication delivered to your address when you are otherwise unable to go out and get it. Our prices are inclusive of the prescriber and pharamcy costs, so you will fill out a set of questions to be looked at by a prescriber, the prescription will be processed in our pharmacy and then shipped to you using your chosen delivery method. You can read a more comprehensive version of how our service works here.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                <div class="ltn__faq-inner ltn__faq-inner-2">
                        <div id="accordion_2">
                            <!-- card -->
                            <div class="card">
                                <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-6" aria-expanded="false">
                                What methods of payment do you accept?
                                </h6>
                                <div id="faq-item-2-6" class="collapse show" data-bs-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>We accept most major payment methods including Visa, Mastercard, and American Express. However, you must use a card that is registered within the UK.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- card -->
                            <div class="card">
                                <h6 class="ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-7" aria-expanded="false"> 
                                Can I use someone else's payment card?
                                </h6>
                                <div id="faq-item-2-7" class="collapse " data-bs-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>No, the payment card that you use to place your order must belong to you. This is for security reasons to make sure your order only goes to the person it is intended for. We also require it as our system checks your identity for non-matching name and if there is any risk associated with your order, our system will automatically refuse your order.</p>
                                    </div>
                                </div>
                            </div>                          
                            <!-- card -->
                            <div class="card">
                                <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-8" aria-expanded="false">
                                How long does it take for an order to be returned?
                                </h6>
                                <div id="faq-item-2-8" class="collapse" data-bs-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>The return time depends on what method you use to send back your order. Please note that not all order is approved for returns so please contact us before you return your order back to us if you are unsure.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- card -->
                            <div class="card">
                                <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-9" aria-expanded="false">
                                My order has been returned to sender. What do I do now?
                                </h6>
                                <div id="faq-item-2-9" class="collapse" data-bs-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>When returning your order back to us, please let us know whether you would like a refund or a replacement to avoid any delays.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- card -->
                            <div class="card">
                                <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-10" aria-expanded="false">
                                Do I need a prescription when placing a consultation?
                                </h6>
                                <div id="faq-item-2-10" class="collapse" data-bs-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>A prescription is not necessary when using our support as you will be issued a private prescription by a pharmacist who is GPhC approved. Once your consultation is accepted, we will send your order to be processed.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- card -->
                           
                        </div>
                    </div>
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