@extends('admin.layouts.default')
@section('title', 'Profile Setting')
@section('content')

    <style>
        .displaynone {
            display: none;
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
                                src="{{ ($user->profile->image ?? '') ? asset('storage/'.$user->profile->image) : asset('assets/admin/img/profile-img.png') }}"
                                alt="Profile" class="rounded-circle">
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
                                        {{$user->short_bio ?? '' }}
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
                                            {{ implode(', ', array_filter([$user->address->apartment, $user->address->address,
                                              $user->address->city, $user->address->state, $user->address->zip_code,
                                              $user->address->country])) }}
                                        </div>
                                    </div>

                                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                        <!-- Profile Edit Form -->
                                        <form class="row g-3 mt-3 needs-validation" method="post"
                                              action="{{ route('admin.profileSetting') }}" novalidate
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mb-3">
                                                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                                    Image</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <img id="img_preview"
                                                         src="{{ ($user->user_pic ?? '') ? asset('storage/'.$user->user_pic) : asset('assets/admin/img/profile-img.png') }}"
                                                         alt="Profile">
                                                    <div class="pt-2">
                                                        <input id="profile_pic" class="d-none profile_pic" type="file"
                                                               name="user_pic" onchange="previewImage(this);">
                                                        <label for="profile_pic"
                                                               class="btn btn-primary bg-primary text-white btn-sm"
                                                               title="Upload new profile image"><i
                                                                class="bi bi-upload"></i></lable>
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
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
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
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="about"
                                                       class="col-md-4 col-lg-3 col-form-label">About</label>
                                                <div class="col-md-8 col-lg-9">
                      <textarea name="short_bio" class="form-control" id="about" style="height: 100px">
                      {{$user->short_bio }}
                      </textarea>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Phone"
                                                       class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="phone" type="text" min="11" max="11"
                                                           class="form-control" id="Phone" value="{{$user->phone }}"
                                                           required>
                                                    <div class="invalid-feedback">Please enter phone!</div>
                                                    @error('phone')
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Address"
                                                       class="col-md-4 col-lg-3 col-form-label">Address</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="address" type="text" class="form-control" id="Address"
                                                           value="{{$user->address ?? ''}}" required>
                                                    <div class="invalid-feedback">Please enter address!</div>
                                                    @error('address')
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary bg-primary">Save Changes
                                                </button>
                                            </div>
                                        </form><!-- End Profile Edit Form -->

                                    </div>


                                    <div class="tab-pane fade pt-3" id="profile-change-password">
                                        <!-- Change Password Form -->
                                        <form class="row g-3 mt-3 needs-validation" method="post"
                                              action="{{ route('admin.passwordChange') }}" novalidate>
                                            @csrf
                                            <div class="row mb-3">
                                                <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                                    Passworddiugharis</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="current_password" type="text" class="form-control"
                                                           id="currentPassword"
                                                           value="{{ old('current_password') ?? ''}}" required>
                                                    <div class="invalid-feedback">Please enter the current password.
                                                    </div>
                                                    @error('current_password')
                                                    <div class="alert-danger text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                                    Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="password" type="text" class="form-control"
                                                           value="{{ old('password') ?? ''}}" id="newPassword" required>
                                                    <div class="invalid-feedback">Please enter a new password.</div>
                                                    @error('password')
                                                    <div class="alert-danger text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirm
                                                    New Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="confirm_password" type="text" class="form-control"
                                                           value="{{ old('confirm_password') ?? ''}}" id="renewPassword"
                                                           required>
                                                    <div class="invalid-feedback">Please re-enter the new password.
                                                    </div>
                                                    @error('confirm_password')
                                                    <div class="alert-danger text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary bg-primary">Change
                                                    Password
                                                </button>
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
@endPushOnce
