@extends('admin.layouts.default')
@section('title', 'Profile Setting')
@section('content')

    <style>
        .displaynone {
            display: none;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
        body {
            padding-top: 70px;
        }

        #responseMessage {
            width: 100%;
        }
        #alert {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
            text-align: center;
        }
    </style>
    <!-- main stated -->
    <main id="main" class="main">

        <div class="pagetitle">
            <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i
                        class="bi bi-arrow-left"></i> Back</a> | Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                            <img
                                src="{{ asset('storage/' . ($user->profile->image ?? 'user_images/default-profile.png')) }}"
                                alt="Profile"
                                class="rounded-circle"
                            />
                            <h2>{{$user->name }}</h2>
                            <div class="social-links mt-2 displaynone">
                                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#profile-overview">Overview
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                        Profile
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#profile-change-password">Change Password
                                    </button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title ">About</h5>
                                    <p class="small fst-italic ">
                                        {{$user->profile->short_bio ?? '' }}
                                    </p>

                                    <h5 class="card-title">Profile Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Full Name</div>
                                        <div class="col-lg-9 col-md-8">{{$user->name }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Phone</div>
                                        <div class="col-lg-9 col-md-8">{{ $user->profile->phone }}</div>
                                    </div>
                                    <!-- <div class="row">
                                      <div class="col-lg-3 col-md-4 label">DOB</div>
                                      <div class="col-lg-9 col-md-8">02-03-2003</div>
                                    </div> -->

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Address</div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ implode(', ', array_filter([$user->address->apartment ?? '', $user->address->address ?? '',
                                              $user->address->city ?? '', $user->address->state ?? '', $user->address->zip_code ?? '',
                                              $user->address->country ?? ''])) }}
                                        </div>
                                    </div>
                                </div>

                                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                        <!-- Profile Edit Form -->
                                        <form class="row g-3 mt-3 needs-validation" method="post"
                                              action="{{ route('web.profileSetting') }}" novalidate
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mb-3">
                                                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                                    Image</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <img id="img_preview"
                                                         src="{{ ($user->profile->image ?? '') ? Storage::url($user->profile->image) : asset('assets/admin/img/profile-img.png') }}">

                                                    <div class="pt-2">
                                                        <input id="profile_pic" class="d-none profile_pic" type="file"
                                                               name="user_pic" onchange="previewImage(this);">
                                                        <label for="profile_pic"
                                                               class="btn btn-primary bg-primary text-white btn-sm"
                                                               title="Upload new profile image"><i
                                                                class="bi bi-upload"></i></label>
                                                            <!-- <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a> -->
                                                    </div>
                                                    <label class="text-danger d-none img-error"></label>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full
                                                    Name</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" class="form-control" id="fullName" name="name"
                                                           value="{{$user->name }}" required>
                                                    <div class="invalid-feedback">Please enter name!</div>
                                                    @error('name')
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Email"
                                                       class="col-md-4 col-lg-3 col-form-label">Email</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="email" type="email" class="form-control" id="Email"
                                                           value="{{$user->email }}" required>
                                                    <div class="invalid-feedback">Please enter valid email!</div>
                                                    @error('email')
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="about"
                                                       class="col-md-4 col-lg-3 col-form-label">About</label>
                                                <div class="col-md-8 col-lg-9">
                                                <textarea name="short_bio" class="form-control" id="about" style="height: 100px">{{$user->profile->short_bio }}</textarea>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="phone" type="text" pattern="^\d{10,15}$" class="form-control" id="Phone"
                                                        value="{{ $user->profile->phone }}" required>
                                                    <div class="invalid-feedback">Please enter a valid phone number (10 to 15 digits)!</div>
                                                    @error('phone')
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                            <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                            <div class="col-md-8 col-lg-9">
                                                <div class="input-group mb-3">
                                                    <input name="address" type="text" class="form-control" id="Address"
                                                        value="{{ implode(', ', array_filter([$user->address->apartment ?? '', $user->address->address ?? '',
                                                        $user->address->city ?? '', $user->address->state ?? '', $user->address->zip_code ?? '',
                                                        $user->address->country ?? ''])) }}" readonly>
                                                    <button type="button" class="btn btn-primary bg-primary btn-sm rounded" id="editAddressBtn" style="margin-left: 6px;">Edit Address</button>
                                                </div>

                                                <div id="addressForm" style="display: none;">

                                                        <label for="apartment" class="form-label">Apartment</label>
                                                        <input type="text" name="apartment" id="apartment" class="form-control mb-2"
                                                            value="{{ $user->address->apartment ?? '' }}">

                                                        <label for="address" class="form-label">Address</label>
                                                        <input type="text" name="address" id="address" class="form-control mb-2"
                                                            value="{{ $user->address->address ?? '' }}">

                                                        <label for="city" class="form-label">City</label>
                                                        <input type="text" name="city" id="city" class="form-control mb-2"
                                                            value="{{ $user->address->city ?? '' }}">

                                                        <label for="state" class="form-label">State</label>
                                                        <input type="text" name="state" id="state" class="form-control mb-2"
                                                            value="{{ $user->address->state ?? '' }}">

                                                        <label for="zip_code" class="form-label">Zip Code</label>
                                                        <input type="text" name="zip_code" id="zip_code" class="form-control mb-2"
                                                            value="{{ $user->address->zip_code ?? '' }}">

                                                        <label for="country" class="form-label">Country</label>
                                                        <input type="text" name="country" id="country" class="form-control mb-2"
                                                            value="{{ $user->address->country ?? '' }}">

                                                </div>

                                                    <div class="invalid-feedback">Please enter address!</div>
                                                    @error('address')
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <button type="reset" class="btn btn-secondary bg-danger">Reset</button>
                                                <button type="submit" class="btn btn-primary bg-primary" onclick="showAlert()">Save</button>

                                                <!-- Alert box -->
                                                <div id="alert" class="alert alert-success alert-dismissible fade" role="alert" style="display: none;">
                                                    Your changes have been saved!
                                                </div>
                                            </div>
                                        </form><!-- End Profile Edit Form -->
                                    </div>


                                    <div class="tab-pane fade pt-3" id="profile-change-password">
                                        <!-- Change Password Form -->
                                        <form id="passwordChangeForm" class="row g-3 mt-3 needs-validation" method="post"
                                              action="{{ route('admin.passwordChange') }}" novalidate>
                                            @csrf
                                            <div class="row mb-3">
                                                <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                                    Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="current_password" type="text" class="form-control"
                                                           id="currentPassword"
                                                           value="{{ old('current_password') ?? ''}}" required>

                                                    <div class="error-message" id="current_password_error"></div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                                    Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="password" type="text" class="form-control"
                                                           value="{{ old('password') ?? ''}}" id="newPassword" required>

                                                    <div class="error-message" id="password_error"></div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirm
                                                    New Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="password_confirmation" type="text" class="form-control"
                                                           value="{{ old('confirm_password') ?? ''}}" id="renewPassword"
                                                           required>

                                                    <div class="error-message" id="password_confirmation_error"></div>
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary bg-primary">Change
                                                    Password
                                                </button>
                                                <div id="responseMessage" class="position-fixed top-0 start-50 translate-middle-x" style="z-index: 1050;"></div>
                                            </div>
                                        </form>


                                    </div>

                                </div><!-- End Bordered Tabs -->

                            </div>
                        </div>

                    </div>
                </div>
        </section>

    </main>

    <!-- End #main -->

@stop

@pushOnce('scripts')
    <script>
    $(document).ready(function() {
        $('#passwordChangeForm').on('submit', function(e) {
            e.preventDefault();

            // Clear previous error messages
            $('.error-message').text('');
            $('#responseMessage').text('');

            $.ajax({
                url: '{{ route('admin.passwordChange') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    location.reload();
                    const alertHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        response.message +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>';

                        $('#responseMessage').html(alertHtml);
                            setTimeout(function() {
                                $('.alert').alert('close');
                            }, 2000);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        // Display error messages below the respective input fields
                        if (errors.current_password) {
                            $('#current_password_error').text(errors.current_password[0]);
                        }
                        if (errors.password) {
                            $('#password_error').text(errors.password[0]);
                        }
                        if (errors.password_confirmation) {
                            $('#password_confirmation_error').text(errors.password_confirmation[0]);
                        }
                    }
                }
            });
        });
    });
    </script>
    <script>
        function previewImage(input) {
            $('.img-error').addClass('d-none').text('');
            var allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
            var maxFileSize = 2 * 1024 * 1024;

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var file = input.files[0];
                var fileType = file.type;

                var extension = fileType.split('/').pop();

                if (allowedTypes.includes(fileType) || (extension.toLowerCase() == 'svg' && fileType == 'image/svg+xml')) {
                    if (file.size <= maxFileSize) {
                        reader.onload = function (e) {
                            $('#img_preview').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(file);
                    } else {
                        $('.img-error').removeClass('d-none').text('File size exceeds the limit of 2MB.');
                        $('#profile_pic').val('');
                    }
                } else {
                    $('.img-error').removeClass('d-none').text('Only images (JPEG, PNG, GIF, SVG) are allowed.');
                    $('#profile_pic').val('');
                }
            }
        }
    </script>
    <!-- address update with edit address -->
    <script>
        document.getElementById('editAddressBtn').addEventListener('click', function() {
        document.getElementById('addressForm').style.display = 'block';
        document.getElementById('Address').style.display = 'none';
        this.style.display = 'none';
        });
    </script>
    <!-- profile update alert -->
    <script>
          function showAlert() {
            var alertBox = document.getElementById("alert");
            alertBox.style.display = "block";
            alertBox.classList.add("show");

            setTimeout(function() {
                alertBox.style.display = "none";
            }, 3000);
        }
    </script>
@endPushOnce
