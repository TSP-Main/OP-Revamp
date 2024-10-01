    <!-- FOOTER AREA START -->
    <footer class="ltn__footer-area  ">
        <div class="footer-top-area  section-bg-1 plr--5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-sm-6 col-12">
                        <div class="footer-widget footer-about-widget">
                            <div class="footer-logo">
                                <div class="site-logo">
                                        <div class="col-md-12"><img src="{{ asset('img/brand-logo/pharmay-footer-logo.webp') }} " width="200px" height="auto" alt="Logo"></div>
                                </div>
                            </div>
                            <p>You NO longer have to wait for GP appointments. NO more visiting your local pharmacy or waiting in long lines. All our services are FREE*, receive genuine medication delivered conveniently and discreetly packaged to your door. </p>
                            <!-- You NO longer need assistance from your GP or your local pharmacy – we do all this online 4U for FREE* here at Online Pharmacy 4U -->
                            <div class="footer-address">
                                <ul>
                                    <li>
                                        <div class="footer-address-icon">
                                            <i class="icon-placeholder"></i>
                                        </div>
                                        <div class="footer-address-info">
                                            <p>Unit 2, Mansfield Station Gateway, Signal Way, Nottingham, NG19 9QH</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="footer-address-icon">
                                            <i class="icon-call"></i>
                                        </div>
                                        <div class="footer-address-info">
                                            <p><a href="tel:01623 572757">01623 572757</a></p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="footer-address-icon">
                                            <i class="icon-mail"></i>
                                        </div>
                                        <div class="footer-address-info">
                                            <p><a href="mailto:info@online-pharmacy4u.co.uk">info@online-pharmacy4u.co.uk</a></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="ltn__social-media mt-20 footer-white">
                                <ul>
                                    <li><a href="https://www.facebook.com/" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="https://x.com/" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="https://www.linkedin.com/" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                                    <li><a href="https://youtube.com/" title="Youtube"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- display none in bootstrap -->


                    <div class="col-xl-2 col-md-6 col-sm-6 col-6">
                        <div class="footer-widget footer-menu-widget clearfix">
                            <h4 class="footer-title">Information</h4>
                            <div class="footer-menu">
                                <ul>
                                    <li><a href="/work">How it works</a></li>
                                    <li><a href="/help">Help</a></li>
                                    <li><a href="{{ route('web.about') }}">About Us</a></li>
                                    <li><a href="/prescribers">Prescribers</a></li>
                                    <!-- <li><a href="/blogs">Blogs</a></li> -->
                                    <li><a href="https://online-pharmacy4u.co.uk/pages/nhs-prescriptions" target="blank">NHS Prescriptions</a></li>
                                    <li><a href="{{ route('web.treatment')}}" target="blank">A-Z Treatment</a></li>
                                    <li><a href="/product_information">Product Information</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-6 col-sm-6 col-6">
                        <div class="footer-widget footer-menu-widget clearfix">
                            <h4 class="footer-title">Important Links</h4>
                            <div class="footer-menu">
                                <ul>
                                    <li><a href="/returns">Returns & Refunds</a></li>
                                    <li><a href="/policy">Policies</a></li>
                                    <li><a href="/delivery">Delivery</a></li>
                                    <li><a href="/responsible_pharmacist">Responsible </a></li>
                                    <li><a href="{{ route('web.conditions')}}" target="blank">A-Z Condition</a></li>
                                    <li><a href="/modern_slavery_act">Modern Slavery Act</a></li>
                                    <!-- <li><a href="/order_tracking">Order tracking</a></li> -->
                                    <li><a href="/faq">FAQ</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-12 col-12">
                        <div class="footer-widget footer-newsletter-widget">
                            <h4 class="footer-title">Newsletter</h4>
                            <p>Subscribe to our weekly Newsletter and receive updates via email.</p>
                            <div class="footer-newsletter">
                                <form action="#">
                                    <input type="email" name="email" placeholder="Email*">
                                    <div class="btn-wrapper">
                                        <button class="theme-btn-1 btn" type="submit"><i class="fas fa-location-arrow"></i></button>
                                    </div>
                                </form>
                            </div>
                            <h5 class="mt-30 payment-heading">We Accept</h5>
                            <img src="{{ asset('img/icons/payment-4.png') }}" alt="Payment Image">
                        </div>
                        <div class="footer-widget pt-5">
                            <a href="https://www.pharmacyregulation.org/registers/pharmacy/location/ng19%2B9qh">
                                <div>
                                    <img class="cert-auther" src="{{ asset('img/brand-logo/R.avif') }}" width="200px" height="auto" alt="Logo">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ltn__copyright-area ltn__copyright-2 section-bg-7  plr--5">
            <div class="container-fluid ltn__border-top-2">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="ltn__copyright-design clearfix">
                            <p>Copyright © {{date('Y')}} All Rights Reserved. </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 align-self-center">
                        <div class="ltn__copyright-menu text-end">
                            <ul>
                                <li><a href="/terms_and_conditions" class="footer-end-links">Terms & Conditions</a></li>
                                <li><a href="/returns"  class="footer-end-links">Claim</a></li>
                                <li><a href="/policy"  class="footer-end-links">Privacy & Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER AREA END -->
