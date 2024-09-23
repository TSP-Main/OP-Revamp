@extends('web.layouts.default')
@section('title', 'Delivery')
@section('content')


<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-image " data-bs-bg="img/Pharmacy4banners/help.webp">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title mt-5 text-white">Delivery</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/" class="text-white"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li class="text-white">Delivery</li>
                            <p class="text-white">Our delivery rates and providers</p>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->
<div class="container pt-0 mt-0">
    <p>Prescription orders must be approved before they can be shipped. Please note that express delivery will only be available after the prescriber approves the item. It usually takes a few hours, but it can take up 72 hours after placing your order. Please note any incorect delivery address details entered we are not responsible and a re-shipping fee will be applied and also if you have missed the multiple re-delivery attemps and the item is returned to us we will have to re-charge you postage to re-ship the item back out to you.</p>
    <p>Prescription items must be shipped signed for or guaranteed to express delivery. Customer services cannot expedite your order so that the prescriber can review it.</p>
    <p>*Please note estimated delivery times include processing time at the warehouse and are calculated from the date the order is placed. During exceptionally busy periods, processing times may be longer and delivery times can be affected by adverse weather conditions. Delivery estimates exclude Bank Holidays, public holidays and weekends. Please check Royal Mail for potential delivery delays in their network. Additional delivery terms apply, please see below for full terms.</p>
    <table class="table table-bordered ">
        <thead>
            <tr>
                <th>Service</th>
                <th>Price</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Royal Mail Tracked 48</td>
                <td>£3.95</td>
                <td>Estimated delivery within 4-5 working days. Delays may occur due to increased volume with couriers.</td>
            </tr>
            <tr>
                <td>Royal Mail Tracked 24</td>
                <td>£4.95</td>
                <td>Estimated delivery within 1-2 working days. Delays may occur due to increased volume with couriers.</td>
            </tr>
            <tr>
                <td>Royal Mail* Tracked 24 (Items over 2kgs)</td>
                <td>£5.95</td>
                <td>For items that weigh 2kg or more will be charged as heavy weighted items this includes high value items. Estimated delivery within 1-2 working days. Delays may accur due to increased volumes with couriers.</td>
            </tr>
            <tr>
                <td>Royal Mail* Tracked 48 (Items over 2kgs)</td>
                <td>£4.95</td>
                <td>For items that weigh 2kg or more will be charged as heavy weighted itemsthis includes high valvue items. Estimated delivery within 4-5 working days. Delays may accur due to increased volumes with couriers.</td>
            </tr>
        </tbody>
    </table>
</div>






@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce