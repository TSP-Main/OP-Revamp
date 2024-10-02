@extends('admin.layouts.default')
@section('title', 'Profile Setting')
@section('content')

    {{-- css added --}}
    <link rel="stylesheet" href="{{ asset('/assets/admin/dist/css/dashstyle.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


    <style>
        /* Background and general styling */
        body {
            background-color: #f8f9fc; /* Light gray background */
        }

        .profile {
            background-color: #ffffff; /* White background for profile section */
            padding: 20px; /* Padding around the profile section */
            border-radius: 10px; /* Rounded corners for the profile section */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Shadow for the profile section */
            margin-top: 20px; /* Margin on top */
        }

        /* Card and Icon styling */
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
            border: none; /* Remove border from cards */
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        /* Breadcrumb styling */
        .breadcrumb {
            background-color: transparent; /* Make breadcrumbs transparent */
            padding: 0;
            margin-bottom: 0;
        }

        .breadcrumb-item a {
            color: #6c757d; /* Breadcrumb link color */
        }

        .breadcrumb-item.active {
            color: #343a40; /* Active breadcrumb item color */
        }

        .breadcrumb-item.active a {
            color: #343a40; /* Active breadcrumb link color */
        }

    </style>

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
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-8 g-4">
                <!-- Total Orders -->
                <div class="col">
                    <div class="card radius-10 shadow border-0 h-100">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="icon-box bg-gradient-info text-white rounded-circle me-3">
                                <i class='bx bxs-cart' style="font-size: 2.5rem;"></i>
                            </div>
                            <div>

                                <p class="mb-0 text-secondary" style="font-size: 1.5rem;"> Total Orders</p>
                                <h4 class="my-1 text-info" id="totalOrders" style="font-size: 2rem;">Loading...</h4>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Total Shipped -->
                <div class="col">
                    <div class="card radius-10 shadow border-0 h-100">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="icon-box bg-gradient-warning text-white rounded-circle me-3">
                                <i class='bx bxs-truck' style="font-size: 2.5rem;"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-secondary" style="font-size: 1.5rem;">Total Shipped</p>
                                <h4 class="my-1 text-warning" id="shippedOrders" style="font-size: 2rem;">Loading...</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Total Received -->
                <div class="col">
                    <div class="card radius-10 shadow border-0 h-100">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="icon-box bg-gradient-success text-white rounded-circle me-3">
                                <i class='bx bxs-package' style="font-size: 2.5rem;"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-secondary" style="font-size: 1.5rem;">Total Received</p>
                                <h4 class="my-1 text-success" id="receivedOrders" style="font-size: 2rem;">Loading...</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Not Approved Orders -->
                <div class="col">
                    <div class="card radius-10 shadow border-0 h-100">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="icon-box bg-gradient-danger text-white rounded-circle me-3">
                                <i class='bx bxs-x-circle' style="font-size: 2.5rem;"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-secondary" style="font-size: 1.5rem;">Not Approved Orders</p>
                                <h4 class="my-1 text-danger" id="NotApprovedOrder" style="font-size: 2rem;">Loading...</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CSS Styles -->


            <div class="row" style="display: none">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                            <img src="{{ $user->user_pic ?? '' ? asset('storage/' . $user->user_pic) : asset('assets/admin/img/profile-img.png') }}"
                                alt="Profile" class="rounded-circle">
                            <h2>{{ $user->name }}</h2>
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
                                        data-bs-target="#profile-overview">Overview</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                        Profile</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#profile-change-password">Change Password</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title ">About</h5>
                                    <p class="small fst-italic ">
                                        {{ $user->short_bio ?? '' }}
                                    </p>

                                    <h5 class="card-title">Profile Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Full Name</div>
                                        <div class="col-lg-9 col-md-8">{{ $user->name }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Phone</div>
                                        <div class="col-lg-9 col-md-8">{{ $user->phone }}</div>
                                    </div>
                                    <!-- <div class="row">
                                                  <div class="col-lg-3 col-md-4 label">DOB</div>
                                                  <div class="col-lg-9 col-md-8">02-03-2003</div>
                                                </div> -->

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Address</div>
                                        <div class="col-lg-9 col-md-8">{{ $user->address }}</div>
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
                                                    src="{{ $user->user_pic ?? '' ? asset('storage/' . $user->user_pic) : asset('assets/admin/img/profile-img.png') }}"
                                                    alt="Profile">
                                                <div class="pt-2">
                                                    <input id="profile_pic" class="d-none profile_pic" type="file"
                                                        name="user_pic" onchange="previewImage(this);">
                                                    <label for="profile_pic" class="btn btn-primary text-white btn-sm"
                                                        title="Upload new profile image"><i class="bi bi-upload"></i>
                                                        </lable>
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
                                                    value="{{ $user->name }}" required>
                                                <div class="invalid-feedback">Please enter name!</div>
                                                @error('name')
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" class="form-control" id="Email"
                                                    value="{{ $user->email }}" required>
                                                <div class="invalid-feedback">Please enter valid email!</div>
                                                @error('email')
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="short_bio" class="form-control" id="about" style="height: 100px">
                      {{ $user->short_bio }}
                      </textarea>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="phone" type="text" min="11" max="11"
                                                    class="form-control" id="Phone" value="{{ $user->phone }}"
                                                    required>
                                                <div class="invalid-feedback">Please enter phone!</div>
                                                @error('phone')
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="address" type="text" class="form-control" id="Address"
                                                    value="{{ $user->address ?? '' }}" required>
                                                <div class="invalid-feedback">Please enter address!</div>
                                                @error('address')
                                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
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
                                                Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="current_password" type="text" class="form-control"
                                                    id="currentPassword" value="{{ old('current_password') ?? '' }}"
                                                    required>
                                                <div class="invalid-feedback">Please enter the current password.</div>
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
                                                    value="{{ old('password') ?? '' }}" id="newPassword" required>
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
                                                    value="{{ old('confirm_password') ?? '' }}" id="renewPassword"
                                                    required>
                                                <div class="invalid-feedback">Please re-enter the new password.</div>
                                                @error('confirm_password')
                                                    <div class="alert-danger text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                        reader.onload = function(e) {
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



    <script>
        function fetchDashbirdDetails() {
            var Userrole = $('#userrole').val();
            $.ajax({
                url: "{{ route('dashboard.details') }}",
                type: 'GET',
                data: {
                    role: Userrole,
                },
                // success: function(response) {

                //     if (response.totalOrders == 0) {
                //         $('#totalOrders').text(0);
                //     } else {
                //         $('#totalOrders').text(response.totalOrders);

                //     }
                //     if (response.paidOrders == 0) {
                //         $('#paidOrders').text(0);
                //     } else {
                //         $('#paidOrders').text(response.paidOrders);
                //     }
                //     if (response.unpaidOrders == 0) {
                //         $('#unpaidOrders').text(0);
                //     } else {
                //         $('#unpaidOrders').text(response.unpaidOrders);
                //     }
                //     if (response.shippedOrders == 0) {
                //         $('#shippedOrders').text(0);
                //     } else {
                //         $('#shippedOrders').text(response.shippedOrders);
                //     }
                //     if (response.receivedOrders == 0) {
                //         $('#receivedOrders').text(0);
                //     } else {
                //         $('#receivedOrders').text(response.receivedOrders);
                //     }
                //     if (response.refundOrders == 0) {
                //         $('#refundOrders').text(0);
                //     } else {
                //         $('#refundOrders').text(response.refundOrders);
                //     }
                //     if (response.notApprovedOrders == 0) {
                //         $('#NotApprovedOrder').text(0);
                //     } else {
                //         $('#NotApprovedOrder').text(response.notApprovedOrders);
                //     }
                //     if (response.totalAmount == 0) {
                //         $('#totalAmount').text(0);
                //     } else {
                //         $('#totalAmount').text(response.totalAmount);

                //     }

                // },
                success: function(response) {
                    // Update icon classes to Bootstrap Icons (`bi` classes)
                    if (response.totalOrders == 0) {
                        $('#totalOrders').html('<i class="bi bi-cart4"></i> 0');
                    } else {
                        $('#totalOrders').html('<i class="bi bi-cart4"></i> ' + response.totalOrders);
                    }
                    if (response.paidOrders == 0) {
                        $('#paidOrders').html('<i class="bi bi-currency-pound"></i> 0');
                    } else {
                        $('#paidOrders').html('<i class="bi bi-currency-pound"></i> ' + response.paidOrders);
                    }
                    if (response.unpaidOrders == 0) {
                        $('#unpaidOrders').html('<i class="bi bi-currency-pound"></i> 0');
                    } else {
                        $('#unpaidOrders').html('<i class="bi bi-currency-pound"></i> ' + response
                            .unpaidOrders);
                    }
                    if (response.shippedOrders == 0) {
                        $('#shippedOrders').html('<i class="bi bi-truck"></i> 0');
                    } else {
                        $('#shippedOrders').html('<i class="bi bi-truck"></i> ' + response.shippedOrders);
                    }
                    if (response.receivedOrders == 0) {
                        $('#receivedOrders').html('<i class="bi bi-box"></i> 0');
                    } else {
                        $('#receivedOrders').html('<i class="bi bi-box"></i> ' + response.receivedOrders);
                    }
                    if (response.refundOrders == 0) {
                        $('#refundOrders').html('<i class="bi bi-arrow-left-right"></i> 0');
                    } else {
                        $('#refundOrders').html('<i class="bi bi-arrow-left-right"></i> ' + response
                            .refundOrders);
                    }
                    if (response.notApprovedOrders == 0) {
                        $('#NotApprovedOrder').html('<i class="bi bi-x-circle"></i> 0');
                    } else {
                        $('#NotApprovedOrder').html('<i class="bi bi-x-circle"></i> ' + response
                            .notApprovedOrders);
                    }
                    if (response.totalAmount == 0) {
                        $('#totalAmount').html('<i class="bi bi-currency-pound"></i> 0');
                    } else {
                        $('#totalAmount').html('<i class="bi bi-currency-pound"></i> ' + response.totalAmount);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        // Call the function to fetch details
        fetchDashbirdDetails();
    </script>
@endPushOnce
