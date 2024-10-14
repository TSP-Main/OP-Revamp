<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Change Password</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="{{asset('assets/admin/img/favicon.png')}}" rel="icon">
    <link href="{{asset('assets/admin/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="{{asset('/assets/admin/plugins/bootstrap/css/bootstrap.min.css')}}">
    </link>
    <!-- custome styling -->
    <link rel="stylesheet" href="{{ asset('/assets/admin/dist/css/style.css') }}">
    <!-- add style link for login page  -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.3/components/logins/login-5/assets/css/login-5.css">


    <style>
        .needs-validation {
            max-width: 80%;
            margin: 0 auto;
        }

        .needs-validation .form-label {
            padding-left: 12px;
        }

        .otp-forget-pass .has-validation input {
            border-radius: 30px;
            padding: 10px;
        }

        .change-custom-pass {
            border-radius: 30px;
            padding: 10px;
        }
    </style>

</head>

<body>
<main>
    <!-- <div class="container"> -->


    <section class="p-3 p-md-4 p-xl-5 otp-forget-pass">
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card border-light-subtle shadow-sm">
                        <div class="row d-flex align-items-center justify-content-center">
                            <div class="col-lg-12  ">
                                <div class="w-100 d-flex align-items-center justify-content-center"
                                     style="border-top-left-radius: 0.4rem; border-top-right-radius: 0.4rem;">
                                    <div class="py-3">
                                        <a class="mobile-logo" href="/"><img src="{{ asset('img/mobile-logo.png') }}"
                                                                             width="100px" alt="Logo"></a>

                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3 p-md-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3 text-center">
                                            <h3 class="fw-bold">Change Password </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mx-auto">
                                    <!-- Display Validation Errors -->
                                    @if(session('status') === 'error')
                                        <div class="alert alert-danger">
                                            <strong>Error:</strong>
                                            @foreach(session('message')->all() as $error)
                                                <p>{{ $error }}</p>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Display Success Message -->
                                    @if(session('status') === 'success')
                                        <div class="alert alert-success">
                                            <strong>Success:</strong> {{ session('message') }}
                                        </div>
                                    @endif

                                    <!-- Display Invalid Credentials or Admin Contact Message -->
                                    @if(session('status') === 'invalid')
                                        <div class="alert alert-danger">
                                            <strong>Error:</strong> {{ session('message') }}
                                        </div>
                                    @endif

                                    <!-- Display Unverified User Message -->
                                    @if(session('status') === 'Unverfied')
                                        <div class="alert alert-warning">
                                            <strong>Warning:</strong> {{ session('message') }}
                                        </div>
                                    @endif

                                    <!-- Display Deactivated User Message -->
                                    @if(session('status') === 'Deactive')
                                        <div class="alert alert-danger">
                                            <strong>Error:</strong> {{ session('message') }}
                                        </div>
                                    @endif

                                    @if(session('status') === 'noexitance')
                                        <div class="alert alert-danger">
                                            <strong>Error:</strong> {{ session('message') }}
                                        </div>
                                    @endif
                                </div>

                                <form class="row g-3 needs-validation" action="{{ route('verifyOtp')}}" method="post"
                                      novalidate>
                                    @csrf
                                    <div class="col-12">
                                        <label for="email" class="form-label">Email</label>
                                        <div class="input-group has-validation">
                                            <input type="email" name="email" class="form-control w-100 " id="email"
                                                   value="{{ session('email') ?? old('email') }}"
                                                   placeholder="write your email" required>
                                            <div class="invalid-feedback"> &nbsp; * Please enter a valid email.</div>
                                            @error('email')
                                            <div class="text-danger"> &nbsp; * {{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="otp" class="form-label">OTP Code</label>
                                        <div class="input-group has-validation">
                                            <input type="text" name="otp" class="form-control w-100 " id="otp"
                                                   value="{{ session('otp') ?? old('otp') }}"
                                                   placeholder="Please enter your password" required>
                                            <div class="invalid-feedback"> &nbsp; * Please enter a valid OTP code.</div>
                                            @error('otp')
                                            <div class="text-danger"> &nbsp; * {{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="password" class="form-label">New Password</label>
                                        <div class="input-group has-validation">
                                            <input type="password" name="password" class="form-control w-100 "
                                                   id="password" placeholder="Please enter your password" required>
                                            <div class="invalid-feedback"> &nbsp; * Please enter your password.</div>
                                            @error('password')
                                            <div class="text-danger"> &nbsp; * {{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary bg-primary w-100 change-custom-pass"
                                                type="submit">Change Password
                                        </button>
                                    </div>
                                    <div class="col-12 ">
                                        <div class="mt-4 mb-3 d-flex justify-content-between">
                                            <!-- Change justify-content-end to justify-content-between -->
                                            <a href="{{route('register')}}" class="link-primary fw-bold">Create a new
                                                account</a>
                                            <a href="{{route('web.index')}}" class="link-primary fw-bold"> <span>Go to Home</span>
                                            </a>
                                        </div>
                                    </div>
                                </form>

                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>

    </section>

</main><!-- End #main -->
<!-- Vendor JS Files -->

<script src="{{asset('/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="{{asset('/assets/admin/plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{asset('/assets/admin/dist/js/main.js')}}"></script>


</body>

</html>
