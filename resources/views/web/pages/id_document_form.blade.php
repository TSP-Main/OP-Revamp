@extends('web.layouts.default')
@section('title', 'Identity Verification')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<style>
    .form-group {
        background-color: #15d3ea2e;
    }
</style>
<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-image " style="margin-bottom: 45px !important; padding-top:60px; padding-bottom:90px; " data-bs-bg="img/banner/verifications.png">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title mt-5 text-black"> Identity Verification</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/" class="text-black"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li class="text-black"> Identity Verification</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<div class="container ">
    <div class="row">
        <div class="col-md-8 pt-5">
            <div class="firstconsultationstart px-2 pt-4">
                <div class="text">
                    <h2>Identity Verification</h2>
                    <p class="mb-3" style="font-size: 17px !important;">
                        Due to new regulatory policies, you are now required to upload one of the following documents below you will only have to do this once to verify you are the person who is placing the order today.
                    </p>
                    <h4 class="mb-3" style="color: #00c4a3; font-weight:bolder;">Accepted Documentation:</h4>
                    <p style="color: #3d7de8;   font-size: 17px !important;">Please upload one of the following documents, by doing so we will verify these documents with 3rd party agencies to validate you.</p>
                    <ul style="color: #3d7de8; font-weight:bolder; padding-left:2.3rem; margin-top:0rem !important; ">
                        <li style="margin-top:0.1rem !important; ">Birth Certificate</li>
                        <li style="margin-top:0.1rem !important; ">Full / Provisional Driving License</li>
                        <li style="margin-top:0.1rem !important; ">UK / EU Passport</li>
                    </ul>
                </div>
                <form id="id_document_form" action="{{route('web.idDocumentForm')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <input class="form-control" style="border-radius: 20px !important;" type="file" name="id_document" id="id_document" required>
                    @error('id_document')
                    <div class="alert-danger text-danger ">{{ $message }}</div>
                    @enderror
                    <div class="my-4">
                        <div class="d-flex align-items-end justify-content-end mb-5  ">
                            <button type="submit" class="btn btn-outline-success fw-bold px-4" style="border:#ced4da 2xp solid;  background-color: #03c4a5; border-radius: 22px !important; ">Proceed to Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- second div  -->
        <div class="col-md-4 bg-info mb-5 rounded-3" style="border-radius: 25px !important;">
            <div class="trackcompleted mb-4 ">
                <div class="text">
                    <h1>How it works</h1>
                    <hr class="my-3">
                </div>
                <div class="q1complete">
                    <div class="mt-4 d-flex gap-2">
                        <span style="width: 29px; height: 29px; background: #00c4a3; color: #fff; text-align: center; border-radius: 50%; ">&#49; </span> <span>Complete a consultation</span>
                    </div>

                    <p>You will need to begin by completing an ailment-based consultation. This will be a set of
                        questions related to your symptoms, medical history and any other information our
                        prescribers might need to be able to recommend a suitable treatment.</p>
                </div>
                <div class="q2complete">
                    <div class="mt-3 d-flex gap-2">
                        <span style="width: 29px; height: 29px; background: #00c4a3; color: #fff; text-align: center; border-radius: 50%; ">&#50; </span> <span>Browse treatments</span>
                    </div>

                    <p>Explore our wide range of medications, diagnostic tools and over the counter treatments
                        to learn more about how they work, what they are used for and how much they cost.</p>
                </div>
                <div class="q3complete">
                    <div class="mt-3 d-flex ">
                        <span style="width: 29px; height: 29px; background: #00c4a3; color: #fff; text-align: center; border-radius: 50%; ">&#51; </span> <span>Wait for a prescriber to review your request</span>
                    </div>

                    <p>You can either wait on our website or you can leave the page and wait for a notification
                        from us to let you know that a prescriber has finished reviewing your consultation.</p>
                </div>
                <div class="q4complete">
                    <div class="mt-3 d-flex gap-2">
                        <span style="width: 29px; height: 29px; background: #00c4a3; color: #fff; text-align: center; border-radius: 50%; ">&#52; </span> <span>Purchase treatment</span>
                    </div>
                    <p>From our selection of available prescription-only and over-the-counter products, the
                        prescriber will let you know which ones they have approved for your condition. From
                        here, you can select your chosen option and continue to payment to complete your order.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


@stop

@pushOnce('scripts')
<script>
    $(document).ready(function() {


    });
</script>

@endPushOnce