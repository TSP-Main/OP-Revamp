@extends('web.layouts.default')
@section('title', 'FAQs')
@section('content')

    
<div class="ltn__utilize-overlay"></div>

<div class="container mt-5">
            <div class="row">
                <div class="col-md-8">
                    <div class="firstconsultationstart">
                        <div class="text">
                            <h2>General Health Questions</h2>
                            <p>The information you provide us is treated with the utmost confidentiality and will be
                                reviewed by a GPhC
                                registered independent prescriber. The questions listed are to provide the prescriber
                                with
                                an appropriate
                                level of information to make an informed decision on whether the treatment is suitable
                                or
                                not.</p>
                        </div>
                        <form action="#">
                            <div class="form-group q1">
                                <div class="d-flex align-items-center ">
                                    <p class="me-auto">Are you registered with a GP practice in the UK?</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>

                                </div>
                                <div class="d-flex flex-column align-items-center d-none shahroz">
                                    <p class="m-2">Why are you not registered with a GP practice?</p>
                                    <textarea class="form-control" name="textarea" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group q2">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Do you give us consent to write to your GP to share information
                                        of
                                        the supply &
                                        information we hold about you? (Please note that certain medication will require
                                        us
                                        to share this
                                        information if you choose NO your medication could get rejected)</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>
                                <div class="d-flex flex-column align-items-center d-none shahroz">
                                    <p class="m-2">Please enter the name of your GP practice....</p>
                                    <textarea class="form-control" name="textarea" rows="5"></textarea>
                                    <p class="mt-2 mb-2">Can't find your GP practice? <button class="text-white p-2"
                                            style=" border-radius: 5px;">Enter address manually</button></p>
                                </div>
                            </div>
                            <!-- Other form groups here -->

                            <div class="form-group" id="q3">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Do you believe you have the capacity to make decisions about your
                                        own
                                        healthcare?</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>
                            </div>
                            <div class="form-group q4">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Have you been diagnosed with any medical conditions?</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>
                                <div class="d-flex flex-column align-items-center d-none shahroz">
                                    <p class="m-2">Please provide more information, including diagnosis, symptoms and
                                        treatment.</p>
                                    <textarea class="form-control" name="textarea" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group q5" id="q5">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Have you ever been diagnosed with a mental health condition?</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>
                                <div class="d-flex flex-column align-items-center d-none shahroz">
                                    <p class="m-2">Please provide more information, including diagnosis, symptoms and
                                        treatment.</p>
                                    <textarea class="form-control" name="textarea" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group q6" id="q6">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Are you currently taking any medication? This includes
                                        prescription-only, over-the-counter and homeopathic medicines.</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>
                                <div class="d-flex flex-column align-items-center d-none shahroz">
                                    <p class="m-2">Which medication, what strength and how often are you taking it?</p>
                                    <textarea class="form-control" name="textarea" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group q7" id="q7">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Do you suffer from any allergies?</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>
                                <div class="d-flex flex-column align-items-center d-none shahroz">
                                    <p class="m-2">What allergies do you have and what are the symptoms you experience
                                        from
                                        an allergic reaction?</p>
                                    <textarea class="form-control" name="textarea" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group q8" id="q8">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Is there anything else you would like to include for the
                                        prescriber?
                                    </p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>
                                <div class="d-flex flex-column align-items-center d-none shahroz">
                                    <p class="m-2">Please provide further information:</p>
                                    <textarea class="form-control" name="textarea" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group" id="q9">
                                <div class="d-flex flex-column align-items-end">
                                    <p class="me-auto">What is your height?</p>
                                    <div class="d-flex justify-content-end" style="line-height: 0;">
                                        <p class="me-2 align-self-end">Feet</p> &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                        <p class="me-2 align-self-end">Inches</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-end mb-2">
                                        <input type="text" class="me-2" placeholder="6">
                                        <input type="text" placeholder="6">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="q10">
                                <div class="d-flex flex-column align-items-end" style="line-height: 0;">
                                    <p class="me-auto">What is your weight?</p>
                                    <div class="d-flex justify-content-end">
                                        <p class="me-2 align-self-end">stone</p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <p class="me-2 align-self-end">pounds</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-end mb-2">
                                        <input type="text" class="me-2" placeholder="6">
                                        <input type="text" placeholder="6">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group q11" id="q11">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Full Name (Legal Name):</p>
                                </div>
                                <div class="d-flex flex-column align-items-center">
                                    <input class="form-control" name="name" rows="5"></input>
                                </div>
                            </div>
                            <div class="form-group q12" id="q12">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Date of Birth (DD/MM/YYYY):
                                    </p>
                                </div>
                                <div class="d-flex flex-column align-items-center">
                                    <input class="form-control" name="text" rows="5"></input>
                                </div>
                            </div>
                            <div class="d-flex align-items-center m-3 mb-5 firstconsultationcontinue">
                                <button type="button" class="btn btn-lg ">Continue consultation</button>
                            </div>
                        </form>
                    </div>
                    <div class=" d-none secondConsultationStart">
                        <div class="text">
                            <h2>Condition Specific Questions</h2>
                            <p>The information you provide us is treated with the utmost confidentiality and will be
                                reviewed by a GPhC registered independent prescriber. The questions listed are to
                                provide the prescriber with an appropriate level of information to make an informed
                                decision on whether the treatment is suitable or not.</p>
                        </div>
                        <form action="#">
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Do you suffer from any heart, liver or kidney problems?</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>

                            </div>
                            <div class="form-group q2">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Do you suffer from any heart, liver or kidney problems?</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>
                                <div class="d-flex flex-column align-items-center d-none shahroz">
                                    <p class="m-2">Please provide further details</p>
                                    <textarea class="form-control" name="textarea" rows="5"></textarea>

                                </div>
                            </div>
                            <!-- Other form groups here -->

                            <div class="form-group q3" id="q3">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Have you ever had a heart attack or stroke?</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>
                                <div class="d-flex flex-column align-items-center d-none shahroz">
                                    <p class="m-2">When was this? (month/year)</p>
                                    <textarea class="form-control" name="textarea" rows="5"></textarea>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Do you suffer from low blood pressure (below 90-50) or experience
                                        faints or collapsing because of it?</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Can you always get an erection when you want?</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Has your GP ever advised you that you are not fit enough for any
                                        physical or sexual activity?</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>

                            </div>
                            <div class="form-group q7" id="q7">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Do you suffer from any condition affecting the shape of your
                                        penis?</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>
                                <div class="d-flex flex-column align-items-center d-none shahroz">
                                    <p class="m-2">Please provide more information about your condition.</p>
                                    <textarea class="form-control" name="textarea" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group" id="q8">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Have you ever experienced an erection lasting longer than 4
                                        hours?
                                    </p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>

                            </div>
                            <div class="form-group" id="q9">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Do you suffer from any eye conditions such as non-arteritic
                                        ischaemic optic neuropathy, retinal problems or retinitis pigmentosa?</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>
                            </div>
                            <div class="form-group" id="q10">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Do you suffer from stomach-duodenal ulcers or blood conditions
                                        such as sickle cell, haemophilia or bleeding disorders?
                                    </p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>

                            </div>
                            <div class="form-group" id="q11">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Do you suffer from diabetes?</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>
                            </div>
                            <div class="form-group q12" id="q12">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Have you tried any erectile dysfunction medication before?</p>
                                    <button type="button" class="btn btn-lg yesButton">Yes</button>
                                    <button type="button" class="btn btn-lg noButton">No</button>
                                </div>
                                <div class="d-flex flex-column align-items-center d-none shahroz">
                                    <p class="m-2">When was this? (month/year)</p>
                                    <textarea class="form-control" name="textarea" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group" id="q13">
                                <div class="d-flex flex-column align-items-center">
                                    <p class="me-auto">Do you agree to the following?</p>
                                    <ul>
                                        <li>You agree to our terms and conditions, privacy policy and acceptable use
                                            policy</li>
                                        <li>You will read the Patient Information Leaflet supplied with your medication
                                        </li>
                                        <li>The treatment is solely for your own use</li>
                                        <li>You are aware you will be subject to a soft check to validate your identity
                                            via Onfido</li>
                                        <li>You have answered all the above questions accurately and truthfully</li>
                                        <li>You understand the prescriber will take your answers in good faith and base
                                            their prescribing decisions accordingly, and that incorrect information can
                                            be hazardous to your health</li>
                                        <li>You will inform your GP of this purchase if appropriate</li>
                                        <li>You give permission to access your NHS Summary Care Record by our
                                            responsible pharmacist in order to identify you correctly, check your
                                            medical history and provide the best possible care</li>
                                    </ul>
                                    <div class="d-flex flex-row align-items-end">
                                        <button type="button" class="btn btn-lg yesButton">Yes</button>
                                        <button type="button" class="btn btn-lg noButton">No</button>
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex align-items-center m-3 mb-5 secondconsultationcontinue">
                                <button type="button" class="btn btn-lg back">Back</button>
                                <button type="button" class="btn btn-lg next">Continue consultation</button>
                            </div>
                        </form>
                    </div>
                    <div class="  d-none thirdaccountcreate">
                        <div class="text">
                            <h2>Account Creation</h2>
                            <p>Already registered? <button>Login here</button></p>
                            <p>Issuing a prescription requires your full name and date of birth as it appears on your
                                ID.</p>
                        </div>
                        <form action="#">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <p class="">First Name</p>
                                        </div>
                                        <div class="d-flex flex-row align-items-center">
                                            <input class="form-control" name="name" rows="5"></input>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <p class="">last Name</p>
                                        </div>
                                        <div class="d-flex flex-row align-items-center">
                                            <input class="form-control" name="name" rows="5"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <p>Gender</p>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-lg yesButton">Male</button>
                                            <button type="button" class="btn btn-lg noButton">Female</button>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <p>Date of Birth (eg: 25 01 1985)</p>
                                        </div>
                                        <div class="d-flex flex-row align-items-center">
                                            <input class="form-control" name="name" rows="5" placeholder="DD"></input>
                                            <span>&nbsp;</span> <!-- Add space -->
                                            <input class="form-control" name="name" rows="5" placeholder="MM"></input>
                                            <span>&nbsp;</span> <!-- Add space -->
                                            <input class="form-control" name="name" rows="5" placeholder="YYYY"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" id="q12">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Mobile number
                                    </p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input class="form-control" name="text" rows="5"></input>
                                </div>
                            </div>
                            <div class="form-group" id="q12">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Email address
                                    </p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input class="form-control" name="text" rows="5"></input>
                                </div>
                            </div>
                            <div class="form-group" id="q12">
                                <div class="d-flex align-items-center">
                                    <p class="me-auto">Password
                                    </p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input class="form-control" name="text" rows="5"></input>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex ">
                                    <p>
                                        <input type="checkbox"> I agree to the Terms & Conditions , Privacy Policy , and
                                        Acceptable Use Policy
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center m-3 mb-5 createaccount">
                                <button type="button" class="btn btn-lg back">Back</button>
                                <button type="button" class="btn btn-lg next">Create Account</button>
                            </div>
                        </form>
                    </div>
                    <div class="d-none fourthproductcategory">
                        <div class="text">
                            <h1>Choose a treatment</h1>
                        </div>
                        <div class="d-flex align-items-center m-3 mb-5 productcategory">
                            <button type="button" class="btn btn-lg back">Back</button>
                            <button type="button" class="btn btn-lg next">Next</button>
                        </div>
                    </div>
                    <div class="d-none fifththanks">
                        
                        <div class=content>
                            <div class="wrapper-1">
                                <div class="wrapper-2">
                                    <h1 class="text-thank">Thank you !</h1>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam earum molestiae natus architecto! Nam, eaque. </p>
                                    <button class="go-home">
                                        go home
                                    </button>
                                </div>
                                <div class="footer-like">
                                    <p>Email not received?
                                        <a href="#">Click here to send again</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- second div  -->
                <div class="col-md-4 bg-info mb-5">
                    <div class="trackcompleted">
                        <div class="text">
                            <h1>How it works</h1>
                            <hr>
                        </div>
                        <div class="q1complete">
                            <div class="mt-5"
                                style="width: 30px; height: 30px; background: #00c4a3; color: #fff; text-align: center; border-radius: 10px; ">
                                &#49;</div> <span>Complete a consultation</span>
                            <p>You will need to begin by completing an ailment-based consultation. This will be a set of
                                questions related to your symptoms, medical history and any other information our
                                prescribers might need to be able to recommend a suitable treatment.</p>
                        </div>
                        <div class="q2complete">
                            <div class="mt-5"
                                style="width: 30px; height: 30px; background: #00c4a3; color: #fff; text-align: center; border-radius: 10px; ">
                                &#50;</div> <span>Browse treatments</span>
                            <p>Explore our wide range of medications, diagnostic tools and over the counter treatments
                                to learn more about how they work, what they are used for and how much they cost.</p>
                        </div>
                        <div class="q3complete">
                            <div class="mt-5"
                                style="width: 30px; height: 30px; background: #00c4a3; color: #fff; text-align: center; border-radius: 10px; ">
                                &#51;</div> <span>Wait for a prescriber to review your request</span>
                            <p>You can either wait on our website or you can leave the page and wait for a notification
                                from us to let you know that a prescriber has finished reviewing your consultation.</p>
                        </div>
                        <div class="q4complete">
                            <div class="mt-5"
                                style="width: 30px; height: 30px; background: #00c4a3; color: #fff; text-align: center; border-radius: 10px; ">
                                &#52;</div> <span>Purchase treatment</span>
                            <p>From our selection of available prescription-only and over-the-counter products, the
                                prescriber will let you know which ones they have approved for your condition. From
                                here, you can select your chosen option and continue to payment to complete your order.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
                const yesButtons = document.querySelectorAll('.yesButton');
                const noButtons = document.querySelectorAll('.noButton');
                const firstConsultationContinueButton = document.querySelector('.firstconsultationcontinue button');
                const secondConsultationContinueButton = document.querySelector('.secondconsultationcontinue button');
                const createAccountButton = document.querySelector('.createaccount .next');
                const productcategorybutton = document.querySelector('.productcategory .next');

                const backButtons = document.querySelectorAll('.back');
                const firstConsultationStart = document.querySelector('.firstconsultationstart');
                const secondConsultationStart = document.querySelector('.secondConsultationStart'); // Corrected typo
                const thirdAccountCreate = document.querySelector('.thirdaccountcreate');
                const fourthcategory = document.querySelector('.fourthproductcategory');
                const fifththanks = document.querySelector('.fifththanks'); // Added fifth step

                function handleClick(event) {
                    const button = event.target;
                    const formGroup = button.closest('.form-group');
                    const shahroz = formGroup.querySelector('.shahroz');

                    if (formGroup.classList.contains('q1')) {
                        // For q1: Show textarea when clicking "No" button
                        if (button.classList.contains('noButton')) {
                            shahroz.classList.remove('d-none');
                        } else {
                            shahroz.classList.add('d-none');
                        }
                    } else if (formGroup.classList.contains('q2')) {
                        // For q2: Show textarea when clicking "Yes" button
                        if (button.classList.contains('yesButton')) {
                            shahroz.classList.remove('d-none');
                        } else {
                            shahroz.classList.add('d-none');
                        }
                    }
                    else if (formGroup.classList.contains('q3')) {
                        // For q3: Show textarea when clicking "Yes" button
                        if (button.classList.contains('yesButton')) {
                            shahroz.classList.remove('d-none');
                        } else {
                            shahroz.classList.add('d-none');
                        }
                    }
                    else if (formGroup.classList.contains('q4')) {
                        // For q4: Show textarea when clicking "Yes" button
                        if (button.classList.contains('yesButton')) {
                            shahroz.classList.remove('d-none');
                        } else {
                            shahroz.classList.add('d-none');
                        }
                    }
                    else if (formGroup.classList.contains('q5')) {
                        // For q2: Show textarea when clicking "Yes" button
                        if (button.classList.contains('yesButton')) {
                            shahroz.classList.remove('d-none');
                        } else {
                            shahroz.classList.add('d-none');
                        }
                    }
                    else if (formGroup.classList.contains('q6')) {
                        // For q2: Show textarea when clicking "Yes" button
                        if (button.classList.contains('yesButton')) {
                            shahroz.classList.remove('d-none');
                        } else {
                            shahroz.classList.add('d-none');
                        }
                    }
                    else if (formGroup.classList.contains('q7')) {
                        // For q2: Show textarea when clicking "Yes" button
                        if (button.classList.contains('yesButton')) {
                            shahroz.classList.remove('d-none');
                        } else {
                            shahroz.classList.add('d-none');
                        }
                    }
                    else if (formGroup.classList.contains('q8')) {
                        // For q2: Show textarea when clicking "Yes" button
                        if (button.classList.contains('yesButton')) {
                            shahroz.classList.remove('d-none');
                        } else {
                            shahroz.classList.add('d-none');
                        }
                    } else if (formGroup.classList.contains('q12')) {
                        // For q2: Show textarea when clicking "Yes" button
                        if (button.classList.contains('yesButton')) {
                            shahroz.classList.remove('d-none');
                        } else {
                            shahroz.classList.add('d-none');
                        }
                    }

                    // Add or remove button color classes
                    formGroup.querySelectorAll('button').forEach(btn => {
                        btn.classList.remove('green-active-button', 'blue-active-button');
                    });
                    // Use correct colors for green and blue buttons
                    button.classList.add(button.classList.contains('yesButton') ? 'green-active-button' : 'blue-active-button');
                }

                yesButtons.forEach(button => {
                    button.addEventListener('click', handleClick);
                });

                noButtons.forEach(button => {
                    button.addEventListener('click', handleClick);
                });
                // initial hide 
                secondConsultationStart.classList.add('d-none');
                thirdAccountCreate.classList.add('d-none');
                fourthcategory.classList.add('d-none');
                fifththanks.classList.add('d-none');

                // Event listener for the "First Consultation Continue" button
                firstConsultationContinueButton.addEventListener('click', function () {
                    firstConsultationStart.classList.add('d-none');
                    secondConsultationStart.classList.remove('d-none');
                    thirdAccountCreate.classList.add('d-none');
                });

                // Event listener for the "Second Consultation Continue" button
                secondConsultationContinueButton.addEventListener('click', function () {
                    secondConsultationStart.classList.add('d-none');
                    thirdAccountCreate.classList.remove('d-none');
                    firstConsultationStart.classList.add('d-none');
                });

                // Event listener for the "third Create Account" button in the third step
                createAccountButton.addEventListener('click', function () {
                    thirdAccountCreate.classList.add('d-none');
                    fourthcategory.classList.remove('d-none');
                    secondConsultationStart.classList.add('d-none');
                    firstConsultationStart.classList.add('d-none');
                });
                // Event listener for the "fourth Create Account" button in the third step
                productcategorybutton.addEventListener('click', function () {
                    fourthcategory.classList.add('d-none');
                    fifththanks.classList.remove('d-none');
                    thirdAccountCreate.classList.add('d-none');
                    secondConsultationStart.classList.add('d-none');
                    firstConsultationStart.classList.add('d-none');
                });


                // Event listeners for the back buttons
                backButtons.forEach((backButton, index) => {
                    backButton.addEventListener('click', function () {
                        if (index === 0) {
                            // If the first back button is clicked, go back to the first step
                            secondConsultationStart.classList.add('d-none');
                            firstConsultationStart.classList.remove('d-none');
                            thirdAccountCreate.classList.add('d-none');
                            fourthcategory.classList.add('d-none');
                            fifththanks.classList.add('d-none');
                        } else if (index === 1) {
                            // If the second back button is clicked, go back to the second step
                            thirdAccountCreate.classList.add('d-none');
                            secondConsultationStart.classList.remove('d-none');
                            firstConsultationStart.classList.add('d-none');
                            fourthcategory.classList.add('d-none');
                            fifththanks.classList.add('d-none');
                        } else if (index === 2) {
                            // If the third back button is clicked, go back to the third step
                            fourthcategory.classList.add('d-none');
                            thirdAccountCreate.classList.remove('d-none');
                            secondConsultationStart.classList.add('d-none');
                            firstConsultationStart.classList.add('d-none');
                            fifththanks.classList.add('d-none');
                        } else if (index === 3) {
                            // If the fourth back button is clicked, go back to the third step
                            fourthcategory.classList.remove('d-none');
                            thirdAccountCreate.classList.add('d-none');
                            secondConsultationStart.classList.add('d-none');
                            firstConsultationStart.classList.add('d-none');
                            fifththanks.classList.add('d-none');
                        }
                    });
                });

                // Event listener for the "Continue consultation" button in the second step
                document.querySelector('.secondconsultationcontinue .next').addEventListener('click', function () {
                    secondConsultationStart.classList.add('d-none');
                    thirdAccountCreate.classList.remove('d-none');
                    firstConsultationStart.classList.add('d-none');
                });

                // Event listener for the "Create Account" button in the third step
                document.querySelector('.thirdcreateaccountbutton').addEventListener('click', function () {
                    fourthcategory.classList.remove('d-none');
                    secondConsultationStart.classList.add('d-none');
                    thirdAccountCreate.classList.add('d-none');
                    firstConsultationStart.classList.add('d-none');
                });
                // Event listener for the "Back" button in the fourth step
                document.querySelector('.fourthproductcategory .next').addEventListener('click', function () {
                    thirdAccountCreate.classList.add('d-none');
                    fourthcategory.classList.add('d-none');
                    secondConsultationStart.classList.add('d-none');
                    firstConsultationStart.classList.add('d-none');
                    fifththanks.classList.remove('d-none');
                });

            });
</script>


@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce