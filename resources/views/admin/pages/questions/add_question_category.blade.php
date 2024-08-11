@extends('admin.layouts.default')
@section('title', 'Add Question Category')
@section('content')
<!-- main stated -->
<main id="main" class="main">

    <div class="pagetitle">
        <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | Add Question Category</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Add Question Category</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card vh-100">
                    <div class="card-body">
                        <!-- Multi Columns Form -->
                        <form class="row g-3 mt-3 needs-validation" method="post" action="{{ route('admin.storeQuestionCategory') }}" novalidate>
                            @csrf
                            <input type="hidden" name="id" value="{{ $category['id'] ?? ''}}">

                            <div class="col-md-8">
                                <label for="name" class="form-label">Category Name</label>
                                <input type="text" name="name" value="{{  $category['name'] ?? old('name') }}" class="form-control" id="name" required>
                                <div class="invalid-feedback">Please enter category name!</div>
                                @error('name')
                                <div class="alert-danger text-danger ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="publish" class="form-label">Status</label>
                                <select id="publish" name="publish" class="form-select">
                                    <option {{ (isset($category['publish']) && $category['publish'] == 'Publish') ? 'selected' : '' }} value="Publish" >Publish</option>
                                    <option  {{ (isset($category['publish']) && $category['publish'] == 'Draft') ? 'selected' : '' }} value="Draft" >Draft</option>
                                </select>
                            </div>
                            {{-- <div class="col-12">
                                <label for="desc" class="form-label">Short Description</label>
                                <textarea rows="4" name="desc" class="form-control" id="desc" placeholder="write short bio"> {{  $collection['desc'] ?? old('desc') }} </textarea>
                            </div> --}}

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary bg-primary">Submit</button>
                                {{-- <button type="reset" class="btn btn-secondary bg-secondary">Reset</button> --}}
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

</script>
@endPushOnce