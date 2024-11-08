@extends('web.layouts.default', ['menu_categories' => $menu_categories])
@section('title', 'Home')
@section('content')
<style>
    .contact-form-box {
        padding: 40px 50px 40px 40px !important;
    }

    #myFile {
        border: 2px dotted #2d91d5;
        padding: 30px;
    }

    @media (max-width: 786px) {
        #myFile {
            border: none;
            padding: 0;
        }
    }
</style>
<div class="ltn__contact-message-area mb-120 mt-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__form-box contact-form-box box-shadow white-bg" style="padding: 40px 50px 40px 40px !important;">
                    <h4 class="title-2">Order Enquiry</h4>
                    <form id="human_request_form" action="{{ route('storeHumanForm')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-item input-item-nam">
                                    <input type="text" name="email" placeholder="Enter email address" required=''>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-item input-item-phone">
                                    <input type="text" name="phone" placeholder="Enter phone number" required=''>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-item input-item-subject">
                                    <input type="text" name="subject" placeholder="Enter subject" required=''>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-item input-item-title">
                                    <input type="text" name="title" placeholder="Name of Animal - For Vet Orders only">
                                </div>
                            </div>
                            <div class="input-item">
                                <label>Enquiry Type</label>
                                <select name="enquiry_type"  class="nice-select" required=''>
                                    <option disabled selected>Select</option>
                                    <option value="Human Vet order">Human Vet order</option>
                                    <option value="App Query" >App Query</option>
                                    <option value="App Account Delete request">App Account Delete request</option>
                                    <option value="Other" >Other</option>
                                </select>
                            </div>

                            <div class="input-item">
                                <label>Device Type - App queries only</label>
                                <select name="device_type" class="nice-select" required=''>
                                    <option disabled selected>Select</option>
                                    <option value="Apple">Apple</option>
                                    <option value="Android" >Android</option>
                                </select>
                            </div>

                            <div class="input-item">
                                <label>NHS login used - App Queries only</label>
                                <select name="nhs_login"  class="nice-select" required=''>
                                    <option disabled selected>Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>

                            <div class="input-item input-item-textarea">
                                <textarea name="message" placeholder="Human Prescription Item(s) required and quantity - For Vet Orders only"></textarea>
                            </div>

                            <div class="input-item mb-25">
                                <textarea id="summernote" name="desc" placeholder="describe here in details"></textarea>
                            </div>

                            <div class="input-item " style="text-align: center;margin-bottom: 30px;">
                                <input type="file" class="form-control p-4" id="myFile" name="file" />
                            </div>

                        </div>
                        <div class="btn-wrapper mt-0 float-right d-flex justify-content-end align-item-center">
                            <button class="btn theme-btn-1 px-4 fw-bold btn-effect-1" type="submit">Submit Query</button>
                        </div>
                        <p class="form-messege mb-0 mt-20"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@pushOnce('scripts')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('summernote');
</script>
@endPushOnce