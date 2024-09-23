@extends('web.layouts.default')
@section('title', 'Product Information Source')
@section('content')


<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-image " data-bs-bg="img/Pharmacy4banners/help.webp">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title mt-5 text-white">Product Information Source</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/" class="text-white"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li class="text-white">Product Information Source</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->


<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="co-md-6">
            <h1>Product Information Source</h1>
            <p>Trusted Sources Only</p>
            <p>Here at Online Pharmacy 4U, we want you to have trust in our content so we make sure that we that all the information you read is from trusted sources when we write our content. Sometimes, it can be hard to separate facts from fiction especially online, which is why our content team uses a list of universally trusted sources for their information. Some of the sources we use the most include from the below:</p>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="row pt-5">
        <div class="col-md-3 text-center border-radius">
            <img src="https://www.chemist-4-u.com/static/version1662525958/frontend/c4u/child/en_GB/Magento_Cms/images/content-writing/nhs.png" alt="" class="product_information">
            <h6>The NHS</h6>
            <p>We use the information provided by the NHS on their website and in literature, they create and send to pharmacy staff</p>
        </div>
        <div class="col-md-3 text-center border-radius">
            <img src="https://www.chemist-4-u.com/static/version1662525958/frontend/c4u/child/en_GB/Magento_Cms/images/content-writing/mhra.png" alt="" class="product_information" >
            <h6>MHRA Patient Information Leaflets (PILs)</h6>
            <p>These leaflets are included with every licensed medication in the UK and they let you know how to use your treatment, when to use it, the active ingredients, and much, much more</p>
        </div>
        <div class="col-md-3 text-center border-radius">
            <img src="https://www.chemist-4-u.com/static/version1662525958/frontend/c4u/child/en_GB/Magento_Cms/images/content-writing/nice.png" alt=""  class="product_information">
            <h6>NICE (National Institute for Health and Care Excellence)</h6>
            <p>Evidence-based guidance for health and social care issues created by a reputable independent committee. The recommendations they provide include medication guidelines and published guidance about medical conditions.</p>
        </div>
        <div class="col-md-3 text-center border-radius">
            <img src="https://www.chemist-4-u.com/static/version1662525958/frontend/c4u/child/en_GB/Magento_Cms/images/content-writing/manufacturer.png" alt=""  class="product_information">
            <h6>Manufacturer’s UK websites</h6>
            <p>We make sure to only use information from manufacturers’ websites that are intended for a British audience. Some medications can differ slightly from country to country and it’s important to get those small details right.</p>
        </div>
    </div>
</div>




@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce