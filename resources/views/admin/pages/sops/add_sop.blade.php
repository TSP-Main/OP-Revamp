@extends('admin.layouts.default')
@section('title', "Add SOP")
@section('content')
<!-- main stated -->
<main id="main" class="main">

    <div class="pagetitle">
        <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | {{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card vh-100">
                    <div class="card-body">
                        <form class="row g-3 mt-3 needs-validation" method="post" action="{{ route('admin.storeSOP') }}" novalidate enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ $sop['id'] ?? ''}}">

                            <div class="col-md-6">
                                <label for="name" class="form-label">File Name</label>
                                <input type="text" name="name" value="{{  $sop['name'] ?? old('name') }}" class="form-control" id="name" required>
                                <div class="invalid-feedback">Please enter file name!</div>
                                @error('name')
                                <div class="alert-danger text-danger ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-6 mt-2 file">
                                <label for="file" class="form-label">Upload File</label>
                                <div class="d-flex align-items-center" style="gap: 20px; justify-content: space-between;">
                                    <input type="file" class="form-control w-100" id="file" name="file" value="" {{ ($sop['file'] ?? NULL) ? '' : 'required' }} onchange="previewMainfile(this)">
                                    <label for="file" class=" d-block ">
                                        <img id="file_preview" src="{{  url('assets/admin/img/upload_btn.png') }}" class="rounded-circle" alt="no file" style="width: 45px; height: 45px;  cursor:pointer;   object-fit: cover;">
                                    </label>
                                    <div class="invalid-feedback">* Upload file!</div>
                                    @error('file')
                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if($sop['file'] ?? NULL)
                                <div>
                                    <input type="hidden" name="sopFilePath_old" value="{{$sop['file']}}">
                                    <a class="fw-bold btn-link mx-2" href="{{ asset('storage/'.$sop['file']) }}" target="_blank">
                                        <i class="bi bi-eye-fill"></i> View File
                                    </a>
                                    <a class="fw-bold btn-link mx-2" href="{{ asset('storage/'.$sop['file']) }}" download>
                                        <i class="bi bi-cloud-download"></i> Download File
                                    </a>
                                </div>
                                @endif
                            </div>

                            <div class="col-md-6 parent-div">
                                <label for="file_for" class="form-label">File For</label>
                                <select id="file_for" name="file_for" class="form-select" required>
                                    <option value="both" @selected(($sop['file_for'] ?? '' )=='both' )>Both Dispensary & Medical Professional</option>
                                    <option value="dispensary" @selected(($sop['file_for'] ?? '' )=='dispensary' )>Only For Dispensary</option>
                                    <option value="doctor" @selected(($sop['file_for'] ?? '' )=='doctor' )>Only For Medical Professional</option>
                                </select>
                                <div class="invalid-feedback">* Select File for!</div>
                                @error('file_for')
                                <div class="alert-danger text-danger ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary bg-primary">Submit</button>
                            </div>
                        </form><!-- End Multi Columns Form -->

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

        function previewMainfile(input) {
            var preview = $('#file_preview');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.attr('src', e.target.result);
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

    });
</script>
@endPushOnce