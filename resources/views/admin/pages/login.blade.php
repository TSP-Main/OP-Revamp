<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="{{asset('assets/admin/img/favicon.png')}}" rel="icon">
    <link href="{{asset('assets/admin/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="{{asset('/assets/admin/plugins/bootstrap/css/bootstrap.min.css')}}">
    </link>
    <!-- custome styling -->
    <link rel="stylesheet" href="{{ asset('/assets/admin/dist/css/style.css') }}">
    <!-- add style link for login page  -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.3/components/logins/login-5/assets/css/login-5.css">


</head>

<body>
    <main>
        <!-- <div class="container"> -->


        <section class="p-3 p-md-4 p-xl-5">
            <div class="container">
                <div class="card border-light-subtle shadow-sm">
                    <div class="row g-0">
                        <div class="col-12 col-md-6 text-bg-primary">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <div class="col-10 col-xl-8 py-3">
                                    <a href="https://myweightlosscentre.co.uk">    
                                        <img class="img-fluid rounded mb-4" loading="lazy" src="{{ asset('/assets/admin/img/Weighloss_final_logo_white.webp') }}" width="245" height="80" alt="BootstrapBrain Logo">
                                    </a>
                                    <hr class="border-primary-subtle mb-4">
                                    <h2 class="h1 mb-4">Start Your Journey with Weight Loss</h2>
                                    <p class="lead m-0">For a happier, more energetic life, start on a transformative weight-loss journey, choosing healthier habits and reaching your fitness objectives.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card-body p-3 p-md-4 p-xl-5">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-5">
                                            <h3>Log in</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">

                                    <div class="card-body">

                            

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
                                        <form class="row g-3 needs-validation" action="{{ route('login')}}" method="post" novalidate>
                                            @csrf
                                            <div class="col-12">
                                                <label for="email" class="form-label">Email</label>
                                                <div class="input-group has-validation">
                                                    <!-- <span class="input-group-text" id="inputGroupPrepend"></span> -->
                                                    <input type="email" name="email" class="form-control" id="email" value="{{ session('email') ?? ''}}" required>
                                                    <div class="invalid-feedback">Please enter valid email.</div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label for="yourPassword" class="form-label">Password</label>
                                                <input type="password" name="password" class="form-control" id="yourPassword" required>
                                                <div class="invalid-feedback">Please enter your password!</div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button class="btn btn-primary bg-primary w-100" type="submit">Login</button>
                                            </div>
                                            
                                        </form>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <hr class="mt-5 mb-4 border-secondary-subtle">
                                        <div class="d-flex  gap-md-4 flex-column flex-md-row justify-content-md-end">
                                            <a href="{{route('register')}}" class="link-secondary text-decoration-none">Create new account</a>
                                            <!-- <a href="#" class="link-secondary text-decoration-none">Forgot password</a> -->
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-12">
                                        <p class=" mb-4">Or sign in with</p>
                                        <div class="d-flex gap-3 flex-column flex-xl-row">
                                            <a href="#" class="btn bsb-btn-xl btn-outline-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                                                    <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z" />
                                                </svg>
                                                <span class="ms-2 fs-6">Google</span>
                                            </a>
                                            <a href="#" class="btn bsb-btn-xl btn-outline-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                                </svg>
                                                <span class="ms-2 fs-6">Facebook</span>
                                            </a>
                                            
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        
                    </div>

        </section>
        <div class=" d-flex justify-content-center mb-3">
          <span class="fz-14">&copy; Copyright 2024 All Rights Design and Developed By
            <a class="fz-14 color-primary" href="https://techsolutionspro.co.uk/">Tech Solutions Pro</a> </span>
        </div><!-- /.col-lg-6 -->
        <!-- </div> -->
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->

    <script src="{{asset('/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="{{asset('/assets/admin/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{asset('/assets/admin/dist/js/main.js')}}"></script>


</body>

</html>