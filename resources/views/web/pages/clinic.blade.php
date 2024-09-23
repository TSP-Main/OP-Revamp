@extends('web.layouts.default')
@section('title', 'faq')
@section('content')


<section class="clinic-main">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <div class="erctile-img">
                <img src="img/product/eritile.webp" alt="...">
                </div>
            </div>
            <div class="col-md-6">
                <div class="erectile-content">
                    <h2>Erectile Dysfunction</h2>
                    <h2>(Impotence)</h2>
                    <P>Many men experience erection problems at some point in their life, and erectile dysfunction (which is also known as ED or impotence) is much more common than you might think.</P>
                    <P>You might struggle to get or keep an erection when you’re feeling particularly stressed or anxious about something (ironically, being anxious about ED doesn’t help this!) or simply because you’ve had a bit too much to drink. However, if you’re experiencing long-term erectile dysfunction it may be caused by other medical conditions, such as diabetes, high blood pressure or cholesterol, or hormonal problems.</P>
                    <button class="btn btn-primary bg-primary my-3 btn-large">Start Erectile Dysfunction (Impotence) Consultation </button>
                    <button class="btn btn-primary bg-primary my-3 small-btn">Start Consultation </button>
                    <button class="btn btn-outline-danger view-btn">View Treatments </button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="treatment my-5 py-5">
    <div class="container">
        <h4 class="text-center pb-4">Erectile Dysfunction (Impotence) Treatments</h4>
        <div class="row">
            <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Card title</h5>
                    <img src="img/product/pro-1.webp" class="card-img-top" alt="...">
                    <a href="#" class="btn btn-outline-danger w-100">Learn more</a>
                </div>
                </div>
            </div>
            <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Card title</h5>
                    <img src="img/product/pro-1.webp" class="card-img-top" alt="...">
                    <a href="#" class="btn btn-outline-danger w-100">Learn more</a>
                </div>
                </div>
            </div>
            <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Card title</h5>
                    <img src="img/product/pro-1.webp" class="card-img-top" alt="...">
                    <a href="#" class="btn btn-outline-danger w-100">Learn more</a>
                </div>
                </div>
            </div>
            <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Card title</h5>
                    <img src="img/product/pro-1.webp" class="card-img-top" alt="...">
                    <a href="#" class="btn btn-outline-danger w-100">Learn more</a>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="explain my-5 py-5">
    <div class="container">
        <h4 class="text-center pt-4 pb-5">Easy Steps for your Medicine</h4>
        <div class="row">
            <div class="col-md-4">
                <div class="explain-step text-center">
                    <img src="img/product/ban-1.png" width="220px" alt="...">
                    <h4 class="mt-2 mb-0 ">Complete a consultation.</h4>
                    <p>With complete privacy and confidentiality your form is checked by a pharmacist independent prescriber.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="explain-step text-center d-block">
                    <img src="img/product/ban-2.png" width="220px" alt="...">
                    <h4 class="mt-2 mb-0">Choose your treatment.</h4>
                    <p>From the list approved by the prescriber, choose your preferred treatment and then wait for it to be dispensed by UK Meds online pharmacy.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="explain-step text-center">
                    <img src="img/product/ban-3.png" width="220px" alt="...">
                    <h4 class="mt-2 mb-0">Receive your delivery.</h4>
                    <p>With next day delivery options available, you can have your treatment sent out to you discreetly within hours.</p>
                </div>
            </div>
        </div>
        <div class="import-btn text-center mt-4">
            <button class="btn btn-danger large-scr">Start Your Erectile Dysfunction (Impotence) consultation</button>
            <button class="btn btn-primary bg-primary my-3 small-btn">Start Consultation </button>
        </div>
        <div class="small-scr">
        <button class="btn btn-danger start">Start consultation</button>
        </div>
    </div>
</section>


@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce