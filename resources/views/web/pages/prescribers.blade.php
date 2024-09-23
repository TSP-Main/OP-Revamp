@extends('web.layouts.default')
@section('title', 'Prescribers')
@section('content')

    
<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-image "  data-bs-bg="img/Pharmacy4banners/help.webp">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title mt-5 text-white">Prescribers</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/" class="text-white"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li class="text-white">Prescribers</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<div class="container text-center pt-0 mt-0">
    <a href="https://www.nmc.org.uk" class="btn-link ">PRESCRIBER: Rebekah Parker. 02I1881S</a>
    <p>You can verify the registration status by clicking on the prescriber's registration number.</p>
<p style="
    margin-bottom: 120px !important;
">
Nursing and Midwifery Council
</p>
</div>




@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce