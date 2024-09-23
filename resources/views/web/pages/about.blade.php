@extends('web.layouts.default')
@section('title', 'About Us')
@section('content')
<style>
    .displaynone {
        display: none;
    }
    .menu-top a {
    color: #000;
    padding: 0 5px;
    font-weight: 400;
    text-decoration: none;
    display: inline-block;
}
.menu-top a:hover {
    color: #3b73b7;
}
.about-us-img-wrap img {
    padding: 10px;
    background: #3c7be6;
    border-radius: 0px !important;
}
.section-subtitle-2::before {
    position: absolute;
    content: "";
    background-color: white !important;
    width: 100%;
    height: 100%;
    top: 50%;
    right: 50%;
    -webkit-transform: translateY(-50%) translateX(50%);
    -ms-transform: translateY(-50%) translateX(50%);
    transform: translateY(-50%) translateX(50%);
    border-radius: 25px;
    opacity: 0.1;
}
.section-subtitle-2 {
    display: inline-block;
    padding: 0px;
    border-radius: 25px;
    position: relative;
}
@media (min-width: 1024px) {
  #one {
    padding-top: 45px;
  }
  #img12 {
    margin-top: -100px;
    margin-right: 15px;
  }
}
.company-value .col-md-4 {
    border-top: #c8d2e7 1px solid;
    border-right: #c8d2e7 1px solid;
}
.company-value .col-md-4:nth-child(-n+3) {
    border-top: none;
}
.value-box {
    padding: 20px 30px;
    text-align: center;
}
.company-value .col-md-4:nth-child(3n) {
    border-right: none;
}

.value-box .val-ic {
    width: 100px;
    height: 100px;
    background: #fff;
    border-radius: 50%;
    line-height: 100px;
    margin: auto;
}
.company-value h4 {
    font-size: 26px;
    padding: 20px 0 0;
}
@media (max-width: 767px) {
    .company-value .col-md-4 {
        border: none;
    }
}
</style>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image " data-bs-bg="img/bg/14.jpg" style="padding-top: 115px;padding-bottom: 115px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12" style="text-align: center;">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title mt-5" style="margin-top: 0px !important;margin-bottom: 0px !important;">About Pharmacy4U</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li>
                                <p style="color: #000;">Online Pharmacy 4U is a private healthcare provider, offering comprehensive medical services.</p>
                            </li>
                        </ul>
                    </div>
                    <div class="menu-top">
                    <a href="#team"> Our Team</a> <a href="#company"> Company Values </a> <a href="#pharmacy"> Pharmacy Regulation</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- ABOUT US AREA START -->
<div class="ltn__about-us-area pt-25--- pb-25 " id="team">
    <div class="container">
        <div class="row">
            <div class="col-lg-6" id="one">
                <div class="about-us-img-wrap about-img-left">
                    <img src="img/pharmacy4banners/Pharmacy_GroupPhoto.webp" alt="About Us Image">
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="about-us-info-wrap">
                    <div class="section-title-area ltn__section-title-2--- mb-30">
                        <h3 class="section-subtitle section-subtitle-2 ltn__secondary-color" style="font-size: 40px;font-weight: 700;">Our Team</h3>
                        <p>Online Pharmacy 4U, located at the heart of England within the East Midlands region. We also now offer same day delivery within the North Nottinghamshire Region. Operating under United Healthcare, company number: 13991146</p>
                        <p>Our GPhC registered pharmacist team are all experienced and regulated to carry out the tasks efficiently.</p><p>
                        Here at Online Pharmacy 4U, our main focus is to care about your health and wellbeing. Whilst carrying out our daily duties to ensure we maintain extremely high level of customer service and support at all times as our main objective.
                        </p> <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ABOUT US AREA END -->

<!-- ABOUT US AREA for basic consultation START -->
<div class="ltn__about-us-area bg-overlay-white-90--- bg-image pt-50 " id="company" style="background-color: #f1f5fa;padding: 50px 0;">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 align-self-center">
                <div class="about-us-info-wrap company-value">
                    <div class="section-title-area ltn__section-title-2--- mb-20">
                        <h1 class="section-title" style="text-align: center;color: #5089e9;    font-size: 40px;
    text-align: center;
    padding: 0 0 25px;
    font-weight: 700;
    color: #3c7ce7;">Company Values</h1>
                        <!-- <p>Our basic consultation services are designed to address your general health concerns and provide guidance on a wide range of common health issues. Whether you have questions about minor ailments, need advice on over-the-counter medications, or want information on maintaining a healthy lifestyle, our team of qualified healthcare professionals is here to assist you. The basic consultation service is user-friendly, allowing you to submit your queries online and receive prompt, confidential responses tailored to your specific needs.</p> -->
                         <div class="row">
           
             
          	<div class="col-md-4 value-box">
                <div class="val-ic">
               
              <img src="//online-pharmacy4u.co.uk/cdn/shop/files/value-1_1.png?v=1623676635" class="" />
              
                </div>
                <h4>Trust</h4>
                <p>Here at Online Pharmacy 4U, you can rest assured that all medications you order via our website all have the correct credentials and can all be cross-checked with the MHRA or the General Pharmaceuticals Council for your peace of mind. </p>
            </div>   
       		
      		
             
          	<div class="col-md-4 value-box">
                <div class="val-ic">
               
              <img src="//online-pharmacy4u.co.uk/cdn/shop/files/value-2_1.png?v=1623676650" class="" />
              
                </div>
                <h4>Genuine</h4>
                <p>All of our products & medications are UK ethically sources so you can rest assured of there origin. Even if you choose a leading brand or a cost-effective generic you can be assured al of our ranges are 100% genuine and effective. </p>
            </div>   
       		
      		
             
          	<div class="col-md-4 value-box">
                <div class="val-ic">
               
              <img src="//online-pharmacy4u.co.uk/cdn/shop/files/value-3_1.png?v=1623676664" class="" />
              
                </div>
                <h4>Privacy</h4>
                <p>We at Online Pharmacy 4U take our customers privacy extremely serious and do not share you medical data with any third party. Any medical notes we may have of you are only accessible by your doctor or pharmacist and we give you our 100% guarantee of their security. </p>
            </div>   
       		
      		
             
          	<div class="col-md-4 value-box">
                <div class="val-ic">
               
              <img src="//online-pharmacy4u.co.uk/cdn/shop/files/value-4_8ba2048f-240a-431d-b3a0-9778d2eeb528.png?v=1623674000" class="" />
              
                </div>
                <h4>Service</h4>
                <p>All our Online Pharmacy 4U dedicated team from our customer services department through to our experienced pharmacist are friendly and eager to help assist you, so if you have a problem or would like to talk to us about something rest assured we are on hand to assist you via online live chat, telephone, or email. </p>
            </div>   
       		
      		
             
          	<div class="col-md-4 value-box">
                <div class="val-ic">
               
              <img src="//online-pharmacy4u.co.uk/cdn/shop/files/value-5_034e9e47-1768-40fa-a2b8-07150328481f.png?v=1623674013" class="" />
              
                </div>
                <h4>Expertise</h4>
                <p>Things such as Medications can be confusing and complicated at times so due to this, we will only ever trust our own medical experts with your medical care. We have a permanent full time dedicated on-site superintendent pharmacist, as well as extremely efficient highly qualified online prescribers giving you peace of mind. </p>
            </div>   
       		
      		
             
          	<div class="col-md-4 value-box">
                <div class="val-ic">
               
              <img src="//online-pharmacy4u.co.uk/cdn/shop/files/value-6_18983210-0429-4e71-8aa3-0c247fe08fde.png?v=1623674027" class="" />
              
                </div>
                <h4>Discretion</h4>
                <p>You never have to worry about our deliveries to you as all of our parcels come in unbranded & unmarked packaging so you can rest assured its contents are for your eyes only </p>
            </div>   
       		
      		 
		</div>
                    </div>
                    <!-- <ul class="ltn__list-item-half clearfix">
                        <li>
                            <i class="fa fa-heart"></i>
                            <p><strong>Trust:</strong> Here at Online Pharmacy 4U, you can rest assured that all medications you order via our website all have the correct credentials and can all be cross-checked with the MHRA or the General Pharmaceuticals Council for your peace of mind.</p>
                        </li>
                        <li>
                            <i class="fas fa-certificate"></i>
                            <p><strong>Genuine:</strong> All of our products & medications are UK ethically sources so you can rest assured of there origin. Even if you choose a leading brand or a cost-effective generic you can be assured al of our ranges are 100% genuine and effective.</p>
                        </li>
                        <li>
                            <i class="fas fa-user-secret"></i>
                            <p><strong>Privacy:</strong> We at Online Pharmacy 4U take our customers privacy extremely serious and do not share you medical data with any third party. Any medical notes we may have of you are only accessible by your doctor or pharmacist and we give you our 100% guarantee of their security.</p>
                        </li>
                        <li>
                            <i class="fas fa-clinic-medical"></i>
                            <p><strong>Service:</strong> All our Online Pharmacy 4U dedicated team from our customer services department through to our experienced pharmacist are friendly and eager to help assist you, so if you have a problem or would like to talk to us about something rest assured we are on hand to assist you via online live chat, telephone, or email.</p>
                        </li>
                        <li>
                            <i class="fas fa-user-tie"></i>
                            <p><strong>Expertise:</strong> Things such as Medications can be confusing and complicated at times so due to this, we will only ever trust our own medical experts with your medical care. We have a permanent full time dedicated on-site superintendent pharmacist, as well as extremely efficient highly qualified online prescribers giving you peace of mind.</p>
                        </li>
                        <li>
                            <i class="fas fa-users"></i>
                            <p><strong>Discretion:</strong> You never have to worry about our deliveries to you as all of our parcels come in unbranded & unmarked packaging so you can rest assured its contents are for your eyes only</p>
                        </li>

                    </ul> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ABOUT US AREA END for basic consultation -->

<!-- ABOUT US AREA product consultation START -->
<div class="ltn__about-us-area bg-overlay-white-90--- bg-image pt-80 pb-80" id="pharmacy">
    <div class="container">
        <div class="row">
        <div class="col-lg-6 align-self-center">
                <div class="about-us-info-wrap">
                    <div class="section-title-area ltn__section-title-2--- mb-20">
                        <h1 class="section-title">Pharmacy Regulation</h1>
                        <p>The pharmacy is registered with the GPhC General Pharmaceutical Council with number 9011792. The Superintendent Pharmacist for online-pharmacy4u is Ali Awaad GPhC Number 2084469. UK Registered Prescribers: Mohamed Mohamed (GPhC Number 2075772)</p>
                    </div>
                    <ul class="ltn__list-item-half clearfix w-100">
                        <li class="w-100">
                        <img src="https://online-pharmacy4u.co.uk/cdn/shop/files/address-c_d0487ed7-7478-4d5d-8703-a4f35fb3b90a.png?v=1623676960" loading="lazy" id="img12">
                            <p><strong>Registered Office Address:</strong><br>
                            United Healthcare - Online Pharmacy 4U<br>
                            20-22 Wenlock Road,<br>
                            London, N1 7GU,<br>
                            United Kingdom</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="about-us-img-wrap about-img-left">
                    <img src="img/pharmacy4banners/Pharmacy_Shelfs.webp" alt="About Us Image" style="
    padding: 0px;
">
                </div>
            </div>

        </div>
    </div>
</div>
<!-- ABOUT US AREA END for product consultation-->

<!-- COUNTDOWN AREA START -->
<div class="ltn__call-to-action-area section-bg-1 bg-image pt-120 pb-120 displaynone" data-bs-bg="img/bg/25.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="call-to-action-inner text-color-white--- text-center---">
                    <div class="section-title-area ltn__section-title-2--- text-center---">
                        <h6 class="ltn__secondary-color">Todays Hot Offer</h6>
                        <h1 class="section-title">Basic Consultation:</h1>
                        <p>Our basic consultation services are designed to address your general health concerns and provide guidance on a wide range of common health issues. Whether you have questions about minor ailments, need advice on over-the-counter medications, or want information on maintaining a healthy lifestyle, our team of qualified healthcare professionals is here to assist you. The basic consultation service is user-friendly, allowing you to submit your queries online and receive prompt, confidential responses tailored to your specific needs.</p>
                    </div>
                    <div class="ltn__countdown ltn__countdown-3 bg-white--" data-countdown="2021/12/28"></div>
                    <div class="btn-wrapper animated">
                        <a href="contact.html" class="theme-btn-1 btn btn-effect-1 text-uppercase">Book Now</a>
                        <a href="shop.html" class="ltn__secondary-color text-decoration-underline">Deal of The Day</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <!-- <img src="img/banner/15.png" alt="#"> -->
            </div>
        </div>
    </div>
</div>
<!-- COUNTDOWN AREA END -->

<!-- PROGRESS BAR AREA START -->
<div class="ltn__progress-bar-area section-bg-1 pt-120 pb-10 mb-120 d-none">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__progress-bar-wrap">
                    <div class="ltn__progress-bar-inner">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="ltn__progress-bar-item-2 text-center">
                                    <div class="progress" data-value='78'>
                                        <span class="progress-left">
                                            <span class="progress-bar border-primary"></span>
                                        </span>
                                        <span class="progress-right">
                                            <span class="progress-bar border-primary"></span>
                                        </span>
                                        <div class="progress-value">
                                            <div class="progress-count">78<sup class="small">%</sup></div>
                                        </div>
                                    </div>
                                    <div class="ltn__progress-info">
                                        <h3>Project Done</h3>
                                        <p>Construction Simulator</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="ltn__progress-bar-item-2 text-center">
                                    <div class="progress" data-value='62'>
                                        <span class="progress-left">
                                            <span class="progress-bar border-danger"></span>
                                        </span>
                                        <span class="progress-right">
                                            <span class="progress-bar border-danger"></span>
                                        </span>
                                        <div class="progress-value">
                                            <div class="progress-count">62<sup class="small">%</sup></div>
                                        </div>
                                    </div>
                                    <div class="ltn__progress-info">
                                        <h3>Country Cover</h3>
                                        <p>Construction Simulator</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="ltn__progress-bar-item-2 text-center">
                                    <div class="progress" data-value='50'>
                                        <span class="progress-left">
                                            <span class="progress-bar border-success"></span>
                                        </span>
                                        <span class="progress-right">
                                            <span class="progress-bar border-success"></span>
                                        </span>
                                        <div class="progress-value">
                                            <div class="progress-count">50<sup class="small">%</sup></div>
                                        </div>
                                    </div>
                                    <div class="ltn__progress-info">
                                        <h3>Completed Co.</h3>
                                        <p>Construction Simulator</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="ltn__progress-bar-item-2 text-center">
                                    <div class="progress" data-value='90'>
                                        <span class="progress-left">
                                            <span class="progress-bar border-warning"></span>
                                        </span>
                                        <span class="progress-right">
                                            <span class="progress-bar border-warning"></span>
                                        </span>
                                        <div class="progress-value">
                                            <div class="progress-count">90<sup class="small">%</sup></div>
                                        </div>
                                    </div>
                                    <div class="ltn__progress-info">
                                        <h3>Happy Clients</h3>
                                        <p>Construction Simulator</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- PROGRESS BAR AREA END -->

<!-- COUNTER UP AREA START -->
<div class="ltn__counterup-area section-bg-1 bg-image bg-overlay-theme-black-80--- pt-115 pb-70 d-none" data-bs-bg="img/bg/30.jpg">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6 align-self-center">
                <div class="ltn__counterup-item text-center">
                    <div class="counter-icon">
                        <!-- <img src="img/icons/icon-img/2.png" alt="#">  -->
                        <i class="flaticon-add-user-1"></i>
                    </div>
                    <h1><span class="counter">733</span><span class="counterUp-icon">+</span> </h1>
                    <h6>Active Clients</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 align-self-center">
                <div class="ltn__counterup-item text-center">
                    <div class="counter-icon">
                        <!-- <img src="img/icons/icon-img/3.png" alt="#">  -->
                        <i class="flaticon-dining-table-with-chairs"></i>
                    </div>
                    <h1><span class="counter">33</span><span class="counterUp-letter">K</span><span class="counterUp-icon">+</span> </h1>
                    <h6>Cup Of Coffee</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 align-self-center">
                <div class="ltn__counterup-item text-center">
                    <div class="counter-icon">
                        <!-- <img src="img/icons/icon-img/3.png" alt="#">  -->
                        <i class="flaticon-package"></i>
                    </div>
                    <h1><span class="counter">100</span><span class="counterUp-icon">+</span> </h1>
                    <h6>Get Rewards</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 align-self-center">
                <div class="ltn__counterup-item text-center">
                    <div class="counter-icon">
                        <!-- <img src="img/icons/icon-img/3.png" alt="#">  -->
                        <i class="flaticon-maps-and-location"></i>
                    </div>
                    <h1><span class="counter">21</span><span class="counterUp-icon">+</span> </h1>
                    <h6>Country Cover</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- COUNTER UP AREA END -->

<!-- TEAM AREA START (Team - 3) -->
<div class="ltn__team-area pt-115 pb-90 displaynone">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area ltn__section-title-2--- text-center">
                    <h1 class="section-title">Our Expert Doctor</h1>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-sm-6">
                <div class="ltn__team-item ltn__team-item-3---">
                    <div class="team-img">
                        <img src="img/team/4.jpg" alt="Image">
                    </div>
                    <div class="team-info">
                        <h4><a href="team-details.html">Rosalina D. William</a></h4>
                        <h6 class="ltn__secondary-color">Scientist</h6>
                        <div class="ltn__social-media">
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="ltn__team-item ltn__team-item-3---">
                    <div class="team-img">
                        <img src="img/team/2.jpg" alt="Image">
                    </div>
                    <div class="team-info">
                        <h4><a href="team-details.html">Kelian Anderson</a></h4>
                        <h6 class="ltn__secondary-color">Dentist</h6>
                        <div class="ltn__social-media">
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="ltn__team-item ltn__team-item-3---">
                    <div class="team-img">
                        <img src="img/team/5.jpg" alt="Image">
                    </div>
                    <div class="team-info">
                        <h4><a href="team-details.html">Miranda H. Halim</a></h4>
                        <h6 class="ltn__secondary-color">Caardiologist</h6>
                        <div class="ltn__social-media">
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- TEAM AREA END -->
<!-- TESTIMONIAL AREA START (testimonial-4) -->
<div class="ltn__testimonial-area section-bg-1  pb-70 d-none">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area ltn__section-title-2 text-center">
                    <h1 class="section-title">What Our Clients Say<span>.</span></h1>
                </div>
            </div>
        </div>
        <div class="row ltn__testimonial-slider-3-active slick-arrow-1 slick-arrow-1-inner">
            <div class="col-lg-12">
                <div class="ltn__testimonial-item ltn__testimonial-item-4">
                    <div class="ltn__testimoni-img">
                        <img src="img/allbanners/clientsfeedback200x200.png" alt="client">
                    </div>
                    <div class="ltn__testimoni-info">
                        <p>Online Pharmacy4U has been a lifesaver! From free delivery to exceptional 24/7 support, they've exceeded my expectations. Plus, the quality of their products is unmatched. I'm a customer for life! </p>
                        <h4>Rosalina D. William</h4>
                        <h6>Founder</h6>
                    </div>
                    <div class="ltn__testimoni-bg-icon">
                        <i class="far fa-comments"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ltn__testimonial-item ltn__testimonial-item-4">
                    <div class="ltn__testimoni-img">
                        <img src="img/allbanners/clientsfeedback200x200.png" alt="client">
                    </div>
                    <div class="ltn__testimoni-info">
                        <p>The convenience of ordering from Online Pharmacy4U is unbeatable. With free delivery, I can rely on them to deliver my medications promptly, saving me time and effort. Highly recommended! </p>
                        <h4>Rosalina D. William</h4>
                        <h6>Founder</h6>
                    </div>
                    <div class="ltn__testimoni-bg-icon">
                        <i class="far fa-comments"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ltn__testimonial-item ltn__testimonial-item-4">
                    <div class="ltn__testimoni-img">
                        <img src="img/allbanners/clientsfeedback200x200.png" alt="client">
                    </div>
                    <div class="ltn__testimoni-info">
                        <p>I've never experienced such dedicated customer support. No matter when I reach out, the team at Online Pharmacy4U is always there to address my concerns promptly. It's the personalised touch that sets them apart. </p>
                        <h4>Rosalina D. William</h4>
                        <h6>Founder</h6>
                    </div>
                    <div class="ltn__testimoni-bg-icon">
                        <i class="far fa-comments"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ltn__testimonial-item ltn__testimonial-item-4">
                    <div class="ltn__testimoni-img">
                        <img src="img/allbanners/clientsfeedback200x200.png" alt="client">
                    </div>
                    <div class="ltn__testimoni-info">
                        <p>Quality matters to me, especially when it comes to my health. Online Pharmacy4U consistently delivers products, and their 100% cashback guarantee provides peace of mind. I trust them completely for all my pharmaceutical needs.</p>
                        <h4>Rosalina D. William</h4>
                        <h6>Founder</h6>
                    </div>
                    <div class="ltn__testimoni-bg-icon">
                        <i class="far fa-comments"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- TESTIMONIAL AREA END -->

<!-- FAQ AREA START (faq-2) (ID > accordion_2) -->
<div class="ltn__faq-area pt-115 pb-120 d-none">
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
                                How to buy a product?
                            </h6>
                            <div id="faq-item-2-1" class="collapse" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Scelerisque eleifend donec pretium vulputate sapien nec sagittis. Proin libero nunc consequat interdum. Condimentum lacinia quis vel eros donec ac.</p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-2" aria-expanded="true">
                                How can i make refund from your website?
                            </h6>
                            <div id="faq-item-2-2" class="collapse show" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <div class="ltn__video-img alignleft">
                                        <img src="img/bg/17.jpg" alt="video popup bg image">
                                        <a class="ltn__video-icon-2 ltn__video-icon-2-small ltn__video-icon-2-border----" href="https://www.youtube.com/embed/Cr4LFOgRGeo?autoplay=1&showinfo=0" data-rel="lightcase:myCollection">
                                            <i class="fa fa-play"></i>
                                        </a>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Scelerisque </p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-3" aria-expanded="false">
                                I am a new user. How should I start?
                            </h6>
                            <div id="faq-item-2-3" class="collapse" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Scelerisque eleifend donec pretium vulputate sapien nec sagittis. Proin libero nunc consequat interdum. Condimentum lacinia quis vel eros donec ac.</p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-4" aria-expanded="false">
                                Returns and refunds
                            </h6>
                            <div id="faq-item-2-4" class="collapse" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Scelerisque eleifend donec pretium vulputate sapien nec sagittis. Proin libero nunc consequat interdum. Condimentum lacinia quis vel eros donec ac.</p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-5" aria-expanded="false">
                                Are my details secured?
                            </h6>
                            <div id="faq-item-2-5" class="collapse" data-bs-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Scelerisque eleifend donec pretium vulputate sapien nec sagittis. Proin libero nunc consequat interdum. Condimentum lacinia quis vel eros donec ac.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <aside class="about-us-img-wrap about-img-right">
                    <img src="img/allbanners/faq600x600.png" alt="Banner Image">
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- FAQ AREA START -->

<!-- FEATURE AREA START ( Feature - 6) -->
<div class="ltn__feature-area section-bg-1 pt-115 pb-90 d-none">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area ltn__section-title-2 text-center">
                    <h6 class="section-subtitle ltn__secondary-color">// features //</h6>
                    <h1 class="section-title">Why Choose Us<span>?</span></h1>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-sm-6 col-12">
                <div class="ltn__feature-item ltn__feature-item-7">
                    <div class="ltn__feature-icon-title">
                        <div class="ltn__feature-icon">
                            <!-- <span><img src="img/icons/icon-img/21.png" alt="#"></span> -->
                            <span><i class="fas fa-hand-holding-medical"></i> </span>
                        </div>
                        <h3><a href="service-details.html">Convenience at Your Doorstep</a></h3>
                    </div>
                    <div class="ltn__feature-info">
                        <p>Opt for the ease of free and timely delivery, bringing your health essentials right to your doorstep.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12">
                <div class="ltn__feature-item ltn__feature-item-7">
                    <div class="ltn__feature-icon-title">
                        <div class="ltn__feature-icon">
                            <!-- <span><img src="img/icons/icon-img/22.png" alt="#"></span> -->
                            <span><i class="fas fa-microscope"></i> </span>
                        </div>
                        <h3><a href="service-details.html">Reliable Quality</a></h3>
                    </div>
                    <div class="ltn__feature-info">
                        <p> Choose us for a commitment to delivering pharmaceutical products of the highest quality, ensuring your health and well-being.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12">
                <div class="ltn__feature-item ltn__feature-item-7">
                    <div class="ltn__feature-icon-title">
                        <div class="ltn__feature-icon">
                            <!-- <span><img src="img/icons/icon-img/23.png" alt="#"></span> -->
                            <span><i class="fas fa-stethoscope"></i> </span>
                        </div>
                        <h3><a href="service-details.html">Customer-Centric Support</a></h3>
                    </div>
                    <div class="ltn__feature-info">
                        <p> Trust in our 24/7 customer support, dedicated to addressing your queries and providing a seamless and reassuring online pharmacy experience.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FEATURE AREA END -->

<!-- BLOG AREA START (blog-3) -->
<div class="ltn__blog-area pt-115 pb-70 d-none">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area ltn__section-title-2--- text-center">
                    <h1 class="section-title">Leatest News Feeds</h1>
                </div>
            </div>
        </div>
        <div class="row  ltn__blog-slider-one-active slick-arrow-1 ltn__blog-item-3-normal">
            <!-- Blog Item -->
            <div class="col-lg-12">
                <div class="ltn__blog-item ltn__blog-item-3">
                    <div class="ltn__blog-img">
                        <a href="blog-details.html"><img src="img/blog/1.jpg" alt="#"></a>
                    </div>
                    <div class="ltn__blog-brief">
                        <div class="ltn__blog-meta">
                            <ul>
                                <li class="ltn__blog-author">
                                    <a href="#"><i class="far fa-user"></i>by: Admin</a>
                                </li>
                                <li class="ltn__blog-tags">
                                    <a href="#"><i class="fas fa-tags"></i>Decorate</a>
                                </li>
                            </ul>
                        </div>
                        <h3 class="ltn__blog-title"><a href="blog-details.html">10 Brilliant Ways To Decorate Your Home</a></h3>
                        <div class="ltn__blog-meta-btn">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-date"><i class="far fa-calendar-alt"></i>June 24, 2021</li>
                                </ul>
                            </div>
                            <div class="ltn__blog-btn">
                                <a href="blog-details.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Blog Item -->
            <div class="col-lg-12">
                <div class="ltn__blog-item ltn__blog-item-3">
                    <div class="ltn__blog-img">
                        <a href="blog-details.html"><img src="img/blog/2.jpg" alt="#"></a>
                    </div>
                    <div class="ltn__blog-brief">
                        <div class="ltn__blog-meta">
                            <ul>
                                <li class="ltn__blog-author">
                                    <a href="#"><i class="far fa-user"></i>by: Admin</a>
                                </li>
                                <li class="ltn__blog-tags">
                                    <a href="#"><i class="fas fa-tags"></i>Interior</a>
                                </li>
                            </ul>
                        </div>
                        <h3 class="ltn__blog-title"><a href="blog-details.html">The Most Inspiring Interior Design Of 2021</a></h3>
                        <div class="ltn__blog-meta-btn">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-date"><i class="far fa-calendar-alt"></i>July 23, 2021</li>
                                </ul>
                            </div>
                            <div class="ltn__blog-btn">
                                <a href="blog-details.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Blog Item -->
            <div class="col-lg-12">
                <div class="ltn__blog-item ltn__blog-item-3">
                    <div class="ltn__blog-img">
                        <a href="blog-details.html"><img src="img/blog/3.jpg" alt="#"></a>
                    </div>
                    <div class="ltn__blog-brief">
                        <div class="ltn__blog-meta">
                            <ul>
                                <li class="ltn__blog-author">
                                    <a href="#"><i class="far fa-user"></i>by: Admin</a>
                                </li>
                                <li class="ltn__blog-tags">
                                    <a href="#"><i class="fas fa-tags"></i>Estate</a>
                                </li>
                            </ul>
                        </div>
                        <h3 class="ltn__blog-title"><a href="blog-details.html">Recent Commercial Real Estate Transactions</a></h3>
                        <div class="ltn__blog-meta-btn">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-date"><i class="far fa-calendar-alt"></i>May 22, 2021</li>
                                </ul>
                            </div>
                            <div class="ltn__blog-btn">
                                <a href="blog-details.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Blog Item -->
            <div class="col-lg-12">
                <div class="ltn__blog-item ltn__blog-item-3">
                    <div class="ltn__blog-img">
                        <a href="blog-details.html"><img src="img/blog/4.jpg" alt="#"></a>
                    </div>
                    <div class="ltn__blog-brief">
                        <div class="ltn__blog-meta">
                            <ul>
                                <li class="ltn__blog-author">
                                    <a href="#"><i class="far fa-user"></i>by: Admin</a>
                                </li>
                                <li class="ltn__blog-tags">
                                    <a href="#"><i class="fas fa-tags"></i>Room</a>
                                </li>
                            </ul>
                        </div>
                        <h3 class="ltn__blog-title"><a href="blog-details.html">Renovating a Living Room? Experts Share Their Secrets</a></h3>
                        <div class="ltn__blog-meta-btn">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-date"><i class="far fa-calendar-alt"></i>June 24, 2021</li>
                                </ul>
                            </div>
                            <div class="ltn__blog-btn">
                                <a href="blog-details.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Blog Item -->
            <div class="col-lg-12">
                <div class="ltn__blog-item ltn__blog-item-3">
                    <div class="ltn__blog-img">
                        <a href="blog-details.html"><img src="img/blog/5.jpg" alt="#"></a>
                    </div>
                    <div class="ltn__blog-brief">
                        <div class="ltn__blog-meta">
                            <ul>
                                <li class="ltn__blog-author">
                                    <a href="#"><i class="far fa-user"></i>by: Admin</a>
                                </li>
                                <li class="ltn__blog-tags">
                                    <a href="#"><i class="fas fa-tags"></i>Trends</a>
                                </li>
                            </ul>
                        </div>
                        <h3 class="ltn__blog-title"><a href="blog-details.html">7 home trends that will shape your house in 2021</a></h3>
                        <div class="ltn__blog-meta-btn">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-date"><i class="far fa-calendar-alt"></i>June 24, 2021</li>
                                </ul>
                            </div>
                            <div class="ltn__blog-btn">
                                <a href="blog-details.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
    </div>
</div>
<!-- BLOG AREA END -->




@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce