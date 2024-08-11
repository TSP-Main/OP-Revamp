@extends('web.layouts.default')
@section('title', 'Login')
@section('content')

<!-- LOGIN AREA START -->
<div class="ltn__login-area pb-65 pt-5">
    <div class="container">
        <div class="row my-5 shadow-custom bg-white">
            <div class="col-md-6 p-0">
                <div class="signup-right-side">
                    <div class="sign-cont">
                        <h2>Hello !</h2>
                        <h4>Welcome</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="my-log-in">
                    <div class="">
                        <div class="card-body">
                            <h3 class="">Sign In To Your Account</h3>
                            <div class="row">
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

                                <div class="col-md-12">
                                    <form action="{{ route('login')}}" method="post" class="mt-4 sign-me ltn__form-box contact-form-box">
                                        @csrf
                                        <input type="text" name="email" style="margin-bottom: 5px !important;" placeholder="Email*" value="{{ session('email') ?? old('email') }}">
                                        @error('email')
                                        <label class="text-danger "> &nbsp; * {{ $message }}</lable>
                                            @enderror
                                            <input type="password" name="password" style="margin-bottom: 5px !important;" placeholder="Password*">
                                            @error('password')
                                            <div class="text-danger"> &nbsp; * {{ $message }}</div>
                                            @enderror
                                            <div class="go-to-btn mt-0 text-end">
                                                <a href="{{route('forgotPassword')}}"><small>FORGOT YOUR PASSWORD?</small></a>
                                            </div>
                                            <div class="btn-wrapper text-center mt-3">
                                                <button class="theme-btn-1 btn btn-block px-4 py-2" type="submit">SIGN IN</button>
                                            </div>
                                            <div class="dont-account text-center mt-3">
                                                <strong>Don't have an account? <span> <a href="/register" class="pe-2" style="font-size: 12px; color:gray">Create Account</a></span> </strong>
                                            </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- LOGIN AREA END -->


@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce