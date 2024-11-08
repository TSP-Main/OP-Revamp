@extends('web.layouts.default')
@section('title', 'Sleep')
@section('content')



<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-image " data-bs-bg="img/banner/sleeping.png">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title mt-5">Sleep</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li>Sleep</li>
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
                    <img src="img/banner/sleeping-second-banner.png" alt="About Us Image">
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="about-us-info-wrap">
                    <div class="section-title-area ltn__section-title-2--- mb-30">
                        <h6 class="section-subtitle section-subtitle-2 ltn__secondary-color d-none">About Us</h6>
                        <h1 class="section-title">Sleeping Tablets</h1>
                        <p>Insomnia is the name for experiencing trouble sleeping and affects many people at some point in their lives. It can be temporary and caused by life events (like stress over an upcoming work commitment) or can persist for weeks or months. There are a number of causes but not getting good quality sleep can affect a person’s wellbeing massively.
                            <br>Treat insomnia with our range of medications to help you fall asleep faster and to reduce the chances of you waking up in the middle of the night.
                        </p>
                        <!-- <p>At Online Pharmacy4U, we prioritise your well-being, ensuring quick and secure delivery of prescriptions right to your doorstep. Our commitment to excellence extends beyond transactions; we're here to provide expert guidance, personalised support, and a user-centric experience. Trust us for a healthier, more accessible future in healthcare.</p> -->
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
<div class="container-fluid mt-3  d-none">
    <div class="ltn__about-us-area pt-5 mt-170 pb-50 ">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="about-us-info-wrap">
                        <div class="section-title-area ltn__section-title-2--- mb-30">
                            <h6 class="section-subtitle section-subtitle-2 ltn__secondary-color d-none">About Us</h6>
                            <h5 class="section-title">In what order should I apply my skincare products?</h5>
                            <p>Regardless of whether your skincare routine contains two products or ten, it’s important to apply them in the right order so they work as they should.</p> <br>
                            <p>First things first, use your cleanser to wash your face before applying any other products, morning or night.</p>
                            <!-- <p>At Online Pharmacy4U, we prioritise your well-being, ensuring quick and secure delivery of prescriptions right to your doorstep. Our commitment to excellence extends beyond transactions; we're here to provide expert guidance, personalised support, and a user-centric experience. Trust us for a healthier, more accessible future in healthcare.</p> -->
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="about-us-img-wrap about-img-left">
                        <img src="img/allbanners/homepage2.webp" style="border-radius: 20px;" alt="About Us Image">
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
                    <h1 class="section-title white-color---">What are Tablets for Sleeping?</h1>
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
                                Why Use Sleeping Tablets?
                            </h6>
                            <div id="faq-item-2-1" class="collapse show" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Having trouble sleeping can be caused by a number of reasons. There are medications which are used in the treatment of insomnia to help you fall asleep quicker and to reduce the chance of waking up in the night.
                                        <br>
                                        Around one in three people suffer from mild insomnia. The consequences of insomnia can be serious, increasing your risks of diabetes, obesity, depression, heart attack and even stroke. Insomnia can be a symptom of other ailments. If you are experiencing depression, anxiety or chronic pain, its not difficult to see how this can cause a lack of sleep.
                                        <br>
                                        While over the counter sleep medicine can be helpful, most of them are based on antihistamines, and these can become less effective the more you take them. In each case, different medications may be more effective than sleeping pills in resolving the underlying cause of your insomnia. Consult with your doctor to determine the best treatment for your specific situation.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-2" aria-expanded="false">
                                Where to get Sleeping Pills Online
                            </h6>
                            <div id="faq-item-2-2" class="collapse " data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>You can get sleeping pills from UK Meds, with overnight shipping most of the week. If you prefer to order your medications online instead of visiting your local pharmacist, UK Meds is a great option. If you need prescription strength sleeping medication, we can fill your prescription online or assist you in getting one with our online doctor service.
                                        <br>
                                        UK Meds offers prescription strength medication, such as zolpidem and zopiclone which can break the cycle of insomnia into a more routine pattern of sleep. A prescription is required for these medicines, and there are potential side effects, including daytime drowsiness, dizziness and potential addiction. If you feel that you need stronger prescription pain medicine, but you don't have a prescription, the UK Meds online doctor service can assist you in obtaining one.
                                    </p>
                                    <h6>Best Prescription Sleeping Pills - The ‘Z’ drugs</h6>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p><strong>Generic name</strong></p>
                                                </td>
                                                <td>
                                                    <p><strong>Trade names</strong> <strong>(UK)</strong></p>
                                                </td>
                                                <td>
                                                    <p><strong>Forms available</strong></p>
                                                </td>
                                                <td>
                                                    <p><strong>Half-life</strong></p>
                                                </td>
                                                <td>
                                                    <p><strong>Dietary considerations</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>zaleplon</p>
                                                </td>
                                                <td>
                                                    <p>Sonata</p>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <p>capsules</p>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <p>about 1 hr</p>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <p>contains lactose</p>
                                                        </li>
                                                        <li>
                                                            <p>contains gelatin</p>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p><a title="zolpidem" href="/zolpidem">zolpidem</a></p>
                                                </td>
                                                <td>
                                                    <p>Stilnoct</p>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <p>tablets</p>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <p>about 2.4 hrs</p>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <p>contains lactose</p>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p><a title="zopiclone" href="/zopiclone">zopiclone</a></p>
                                                </td>
                                                <td>
                                                    <p>Zimovane</p>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <p>tablets</p>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <p>about 5 hrs</p>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <p>contains lactose</p>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-3" aria-expanded="false">
                                Common over-the-counter sleep medications include:
                            </h6>
                            <div id="faq-item-2-3" class="collapse" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>
                                    <ul>
                                        <li>Diphenhydramine (found in brand names like Nytol, Sominex, Sleepinal, Compoz)</li>
                                        <li>Doxylamine (brand names such as Unisom, Nighttime Sleep Aid)</li>
                                    </ul>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-4" aria-expanded="false">
                                Where to Buy Sleep Tablets in the UK?
                            </h6>
                            <div id="faq-item-2-4" class="collapse" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>You can purchase the best sleeping pills here at UK Meds. We offer overnight shipping most days of the week. You will be able to determine as you check out when your order will arrive. If you don't have a prescription for sleeping medication, our online doctor service can help you determine if prescription sleep medication is right for you.</p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-5" aria-expanded="false">
                                What Kind of Sleeping Tablets can you Buy Over The Counter?
                            </h6>
                            <div id="faq-item-2-5" class="collapse" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>There are two types of sleeping medicine, prescription and non-prescription. You can buy both types here on UK Meds. If you don't have a prescription, our online doctor service may be able to help you obtain the medication you need.</p>
                                    <p><strong>UK Sleep Tablets</strong></p>
                                    <p>The following are our prescribed sleep medicines:</p>
                                    <ul>
                                        <li>Zopiclone</li>
                                        <li>Zolpidem</li>
                                        <li>Zimovane</li>
                                    </ul>
                                    <p><strong>Non-Prescription Sleep Medication</strong></p>
                                    <p>The following are sleep medicines we sell which do not require a prescription:</p>
                                    <ul>
                                        <li>Nytol One-A-Night</li>
                                        <li>Nytol Herbal Tablets</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-6" aria-expanded="false">
                                Types of Sleeping Tablets
                            </h6>
                            <div id="faq-item-2-6" class="collapse" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>There are several different types of prescription sleeping pills, classified as sedative hypnotics. In general, these medications act by working on receptors in the brain to slow down the nervous system. Some medications are used more for inducing sleep, while others are used for staying asleep. An example is Ambien, the branded version of generic Zolpidem.
                                        <br>
                                        Most sleep medications are classified as "sedative hypnotics." That's a specific class of drugs used to induce and/or maintain rest. Sedative hypnotics include benzodiazepines, barbiturates, and various hypnotics. Benzodiazepines such as Xanax, Valium, Ativan, and Librium are anti-anxiety medications.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-7" aria-expanded="false">
                                What are Sleeping Pills?
                            </h6>
                            <div id="faq-item-2-7" class="collapse" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>They allow you to go to sleep more easily. A person is prescribed sleeping medication if they are having difficulty getting to sleep. They are also called sleeping pills, sleep aids, sleep medicine, sedatives or hypnotics.</p>
                                    <h6>What are some of the different types of sleeping medications?</h6>
                                    <p>There are many different classes and brands of sleeping medicine. Your doctor will suggest the one he or she feels will best work for you based on the cause and length of time you have been having trouble sleeping, as well as the specific type of insomnia you are experiencing. Your doctor will also take into consideration any other health conditions you may have, or medications you are taking. Commonly used sleeping pills include:</p>
                                    <ul>
                                        <li>Ambien®, Ambien® CR (zolpidem tartrate)</li>
                                        <li>Dalmane® (flurazepam hydrochloride)</li>
                                        <li>Halcion® (triazolam)</li>
                                        <li>Lunesta® (eszopiclone)</li>
                                        <li>Prosom® (estazolam)</li>
                                        <li>Restoril® (temazepam)</li>
                                        <li>Rozerem® (ramelteon)</li>
                                        <li>Silenor® (doxepin)</li>
                                        <li>Desyrel® (trazodone)</li>
                                        <li>Belsomra® (suvorexant)</li>
                                        <li>Over-the-counter sleeping pills (including antihistamines, melatonin, herbal formulations, and others)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-8" aria-expanded="false">
                                Prescription and Non-Prescription Sleeping Tablets
                            </h6>
                            <div id="faq-item-2-8" class="collapse" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>What are the names of sleeping tablets? Below you will find a list of both prescription and non-prescription sleeping aids. List of sleeping medicines:</p>
                                    <ul>
                                        <li>Zopiclone (Prescription)</li>
                                        <li>Zolpidem (Prescription)</li>
                                        <li>Zimovane (Prescription)</li>
                                        <li>Nytol (Non-Prescription)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-6" aria-expanded="false">
                                Names of Strong Sleeping Pills
                            </h6>
                            <div id="faq-item-2-6" class="collapse" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Strong (Prescription) sleeping tablets include the following.</p>
                                    <table summary="Prescription sleep medication options">
                                        <thead>
                                            <tr>
                                                <th>Sleep medication</th>
                                                <th>Helps you fall asleep</th>
                                                <th>Helps you stay asleep</th>
                                                <th>Can lead to dependence</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Doxepin (Silenor)</td>
                                                <td>&nbsp;</td>
                                                <td>✔</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Estazolam</td>
                                                <td>✔</td>
                                                <td>✔</td>
                                                <td>✔</td>
                                            </tr>
                                            <tr>
                                                <td>Eszopiclone (Lunesta)</td>
                                                <td>✔</td>
                                                <td>✔</td>
                                                <td>✔</td>
                                            </tr>
                                            <tr>
                                                <td>Ramelteon (Rozerem)</td>
                                                <td>✔</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Temazepam (Restoril)</td>
                                                <td>✔</td>
                                                <td>✔</td>
                                                <td>✔</td>
                                            </tr>
                                            <tr>
                                                <td>Triazolam (Halcion)</td>
                                                <td>✔</td>
                                                <td>&nbsp;</td>
                                                <td>✔</td>
                                            </tr>
                                            <tr>
                                                <td>Zaleplon (Sonata)</td>
                                                <td>✔</td>
                                                <td>&nbsp;</td>
                                                <td>✔</td>
                                            </tr>
                                            <tr>
                                                <td>Zolpidem (Ambien, Edluar, Intermezzo, Zolpimist)</td>
                                                <td>✔</td>
                                                <td>&nbsp;</td>
                                                <td>✔</td>
                                            </tr>
                                            <tr>
                                                <td>Zolpidem extended release (Ambien CR)</td>
                                                <td>✔</td>
                                                <td>✔</td>
                                                <td>✔</td>
                                            </tr>
                                            <tr>
                                                <td>Suvorexant (Belsomra)</td>
                                                <td>✔</td>
                                                <td>✔</td>
                                                <td>✔</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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