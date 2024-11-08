@extends('web.layouts.default')
@section('title', 'Contact Us')
@section('content')


<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-image"  data-bs-bg="img/bg/14.webp">
    <div class="container">
        <div class="row mt-5 ">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title text-black">Contact Us</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li class="mt-0"><a class="text-black" href="/"><span class="ltn__secondary-color"><i class="fas fa-home text-white"></i></span > Home</a></li>
                            <li class="text-black">Contact Us Now</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- CONTACT ADDRESS AREA START -->
<div class="ltn__contact-address-area mb-90">
    <div class="container">
        <div class="row g-3">
            <div class="col-lg-4">
                <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow" style="height: 100%;">
                    <div class="ltn__contact-address-icon">
                        <img src="img/icons/10.png" alt="Icon Image">
                    </div>
                    <h3>Email Address</h3>
                    <p>info@online-pharmacy4u.co.uk</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow" style="height: 100%;">
                    <div class="ltn__contact-address-icon">
                        <img src="img/icons/11.png" alt="Icon Image">
                    </div>
                    <h3>Phone Number</h3>
                    <p>01623 572757</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow" style="height: 100%;">
                    <div class="ltn__contact-address-icon">
                        <img src="img/icons/12.png" alt="Icon Image">
                    </div>
                    <h3>Office Address</h3>
                    <p>Unit 2, Mansfield Station Gateway, <br>
                        Signal Way, Nottingham, NG19 9QH, <br>
                        United Kingdom</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CONTACT ADDRESS AREA END -->

<!-- CONTACT MESSAGE AREA START -->
<div>
    <div class="container text-center">
        <p>For any inquiries, assistance, or feedback, please feel free to reach out to us. <br> Your well-being is our priority, and we are here to support you in any way we can.</p>
    </div>
</div>
<div class="ltn__contact-message-area mb-120 mb-5" >
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__form-box contact-form-box box-shadow white-bg">
                    <h4 class="title-2">Get A Quote</h4>
                    <form id="contact-form" action="mail.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-item input-item-name ltn__custom-icon">
                                    <input type="text" name="name" placeholder="Enter your name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-item input-item-email ltn__custom-icon">
                                    <input type="email" name="email" placeholder="Enter email address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-item input-item-subject ltn__custom-icon">
                                    <input type="text" name="subject" placeholder="Enter the subject">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-item input-item-phone ltn__custom-icon">
                                    <input type="text" name="phone" placeholder="Enter phone number">
                                </div>
                            </div>
                        </div>
                        <div class="input-item input-item-textarea ltn__custom-icon">
                            <textarea name="message" placeholder="Enter message"></textarea>
                        </div>
                        <p><label class="input-info-save mb-0"><input type="checkbox" name="agree"> Save my name, email, and website in this browser for the next time I comment.</label></p>
                        <div class="btn-wrapper mt-0">
                            <button class="btn theme-btn-1 btn-effect-1 text-uppercase" type="submit">get a free service</button>
                        </div>
                        <p class="form-messege mb-0 mt-20"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CONTACT MESSAGE AREA END -->

<!-- GOOGLE MAP AREA START -->
<div class="google-map " styl="height: 500px;">
   
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2392.0618872254536!2d-1.205329718142586!3d53.16292887708169!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4879bd846e3b26e7%3A0x46c0b16171a8eb36!2sMansfield%20Woodhouse%2C%20Mansfield%20NG19%209QH!5e0!3m2!1sen!2suk!4v1709763415423!5m2!1sen!2suk" width="100%" height= "80%" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

</div>
<!-- GOOGLE MAP AREA END -->

<!-- CALL TO ACTION START (call-to-action-6) -->
<div class="ltn__call-to-action-area call-to-action-6 before-bg-bottom p-0 m-0" data-bs-bg="img/1.jpg--">
    <div class="container-fluid p-0 m-0">
        <div class="row p-0 m-0">
            <div class="col-lg-12">
                <div class="call-to-action-inner call-to-action-inner-6 ltn__secondary-bg position-relative text-center---">
                    <div class="coll-to-info text-color-white">
                        <h1 class="mt-4">WE ARE READY TO SERVE YOU 24 HOURS!</h1>
                    </div>
                    <div class="btn-wrapper">
                        <a class="btn btn-effect-3 btn-white border-radius" href="/shop" style="display: flex; align-items: center; justify-content: center;">Shop Now<i class="icon-next ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CALL TO ACTION END -->


@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce