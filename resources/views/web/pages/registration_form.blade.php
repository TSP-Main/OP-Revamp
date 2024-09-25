@extends('web.layouts.default')
@section('title', 'Registration Form')
@section('content')
<style>
    input[type="number"],
    input[type="date"] {
        background-color: var(--white);
        border: 2px solid;
        border-color: var(--border-color-9);
        height: 65px;
        -webkit-box-shadow: none;
        box-shadow: none;
        padding-left: 20px;
        font-size: 16px;
        color: var(--ltn__paragraph-color);
        width: 100%;
        margin-bottom: 30px;
        border-radius: 0;
        padding-right: 40px;
    }

    select {
        background-color: var(--white);
        border: 2px solid;
        border-color: var(--border-color-9);
        height: 65px;
        -webkit-box-shadow: none;
        box-shadow: none;
        padding-left: 20px;
        font-size: 16px;
        color: var(--ltn__paragraph-color);
        width: 100%;
        margin-bottom: 30px;
        border-radius: 30px !important;
        padding-right: 40px;
    }

    #phone::-webkit-inner-spin-button,
    #phone::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="file"]::-webkit-file-upload-button {
        height: 50px;
    }
</style>


<!-- LOGIN AREA START (Register) -->
<div class="ltn__login-area pb-110 py-5">
    <div class="container">
        <div class="row bg-white">
            <div class="crate-here ps-5 pt-4">
                <h4>Your Details</h4>
                <p>Please complete the below details to create your account and continue your consultation.</p>
                <div class="go-to-btn mt-4">
                    <a href="/admin"><strong>ALREADY HAVE AN ACCOUNT?</strong></a>
                    <a href="/admin" class="btn-primary sign-btn text-center">sign in</a>
                </div>
            </div>
            <div class="col-lg-12 pt-4">
                <form action="{{ route('web.user_register') }}" method="post" class=" reg-me ltn__form-box contact-form-box needs-validation" type="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
                            <div class="invalid-feedback">Please enter your name!</div>
                            @error('name')
                            <div class="alert-danger text-danger ">{{ $message }}</div>
                            @enderror

                            <input type="number" id="phone" name="phone" placeholder="Phone Number" value="{{ old('phone') }}" required>
                            <div class="invalid-feedback">Please enter Phone Number!</div>
                            @error('phone')
                            <div class="alert-danger text-danger ">{{ $message }}</div>
                            @enderror
                            <select name="gender" id="gender" class="form-select" required>
                                <option value=""> Select Gender</option>
                                <option {{ old('gender') == 'male' ? 'selected' : ''}} value="male"> Male</option>
                                <option {{ old('gender') == 'female' ? 'selected' : ''}} value="female"> Female</option>
                            </select>
                            <div class="invalid-feedback">Please select your gender!</div>
                            @error('gender')
                            <div class="alert-danger text-danger ">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <input type="email" name="email" placeholder="Email*" value="{{ old('email') }}" required>
                            <div class="invalid-feedback">Please enter your email!</div>
                            @error('email')
                            <div class="alert-danger text-danger ">{{ $message }}</div>
                            @enderror

                            <div class="row ">
                                <div class="col-4">
                                    <select name="day" class="form-select" required>
                                        <option value="" disabled selected>Day</option>
                                        @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}" {{ old('day') == $i ? 'selected' : '' }}>{{ $i }}</option>@endfor
                                    </select>
                                    <div class="invalid-feedback">Please select the day!</div>
                                    @error('day')
                                    <div class="alert-danger text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select name="month" class="form-select" required>
                                        <option value="" disabled selected>Month</option>
                                        @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}" {{ old('month') == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                            @endfor
                                    </select>
                                    <div class="invalid-feedback">Please select the month!</div>
                                    @error('month')
                                    <div class="alert-danger text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select name="year" class="form-select" required>
                                        <option value="" disabled selected>Year</option>
                                        @for ($i = 2006; $i >= 1900; $i--)
                                        <option value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <div class="invalid-feedback">Please select the year!</div>
                                    @error('year')
                                    <div class="alert-danger text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mt-0">
                                <p style="color: #3d7de8 ;">* Make a strong password</p>
                            </div>
                            <input type="password" name="password" placeholder="Password*" value="{{ old('password') }}" required>
                            <input type="password" name="password_confirmation" placeholder="Password*" value="{{ old('password') }}" required>
                            <div class="invalid-feedback">Please enter your password!</div>
                            @error('password')
                            <div class="alert-danger text-danger ">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="mb-1 small px-1">
                                <p style="color: #3d7de8 ;">* We need to verify your identity before providing treatments. Please use your home address below. You can add a different shipping address at the checkout.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="zip_code" placeholder="Postal Code" value="{{ old('zip_code') }}" required>
                            <div class="invalid-feedback">Please enter your postal code!</div>
                            @error('zip_code')
                            <div class="alert-danger text-danger ">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="city" placeholder="city" value="{{ old('city') }}" required>
                            <div class="invalid-feedback">Please enter your city!</div>
                            @error('city')
                            <div class="alert-danger text-danger ">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="address" placeholder="address" value="{{ old('address') }}" required>
                            <div class="invalid-feedback">Please enter your address!</div>
                            @error('address')
                            <div class="alert-danger text-danger ">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="apartment" placeholder="apartment, suite, etc(optional)" value="{{ old('address') }}">

                            @error('apartment')
                            <div class="alert-danger text-danger ">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mb-4">
                            <div class="mb-1 small px-1">
                                <h3 style="color: #3d7de8; margin-bottom: 5px;">Identity Verification</h3>
                                <p style="color: #3d7de8 ;">
                                    Due to new regulatory policies, you are now required to upload one of the following documents below you will only have to do this once to verify you are the person who is placing the order today.
                                </p>
                                <p style="color: #00c4a3; font-weight:bolder;">Accepted Documentation:</p>
                                <p style="color: #3d7de8;">Please upload one of the following documents, by doing so we will verify these documents with 3rd party agencies to validate you.</p>
                                <ul style="color: #3d7de8; font-weight:bolder; padding-left:2.3rem; margin-top:0rem !important; ">
                                    <li style="margin-top:0.1rem !important; ">Birth Certificate</li>
                                    <li style="margin-top:0.1rem !important; ">Full / Provisional Driving License</li>
                                    <li style="margin-top:0.1rem !important; ">UK / EU Passport</li>
                                </ul>
                            </div>
                            <input class="form-control bg-white " type="file" name="id_document" id="id_document" required>
                            @error('id_document')
                            <div class="alert-danger text-danger ">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class=" px-3 mb-2">
                            <button class="theme-btn-1 btn reverse-color btn-block text-center px-3" type="submit">CREATE ACCOUNT</button>
                        </div>
                        <div class="by-agree">
                            <p>By creating an account, you agree to our:</p>
                            <p><a href="/terms_and_conditions/">TERMS OF CONDITIONS &nbsp; &nbsp; | &nbsp; &nbsp; PRIVACY POLICY</a></p>
                            <div class="go-to-btn mt-25">
                                <a href="/admin"><strong>ALREADY HAVE AN ACCOUNT?</strong></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- LOGIN AREA END -->

@stop

@pushOnce('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

<!-- Script to initialize the datepicker -->

</script>


@endPushOnce
