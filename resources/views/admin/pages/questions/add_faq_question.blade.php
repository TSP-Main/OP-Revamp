@extends('admin.layouts.default')
@section('title', 'Add FAQ Question')
@section('content')
<style>
    .select2-selection__rendered {
        line-height: 35px !important;
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
    }

    .select2-selection__arrow {
        height: 40px !important;
    }

    .btn_theme {
        background: #03bd8d;
        border: #03bd8d 1px solid;
    }

    .hide {
        display: none;
    }
</style>
<!-- main stated -->
<main id="main" class="main">

    <div class="pagetitle">
        <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | Add FAQ Question</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Add FAQ Question</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <!-- Multi Columns Form -->
                        <form class="row g-3 mt-3 needs-validation" method="post" action="{{ route('admin.StorefaqQuestions') }}" novalidate>
                            @csrf
                            <input type="hidden" name="id" id="question_id" value="{{ $question['id'] ?? ''}}">
                            <div class="col-md-12 d-block">
                                <label for="product_id" class="form-label fw-bold">Select product</label>
                                <select id="product_id" name="product_id" class="form-select select2" data-placeholder="choose product" required>
                                    <option value=""></option>
                                    
                                    @foreach ($products as $key => $value)
                                    <option {{ (isset($question['product_id']) && $value['id'] == $question['product_id']) ? 'selected' : '' }} {{ ($value['id'] == old('product_id')) ? 'selected' : '' }} value="{{ $value['id'] ?? '' }}">{{ $value['title'] ?? '' }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select product id!</div>
                                @error('category_id')
                                <div class="alert-danger text-danger ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-10">
                                <label for="name" class="form-label fw-bold">Title</label>
                                <input type="text" name="title" value="{{  $question['title'] ?? old('title') }}" class="form-control" id="title" required>
                                <div class="invalid-feedback">Please enter question title!</div>
                                @error('name')
                                <div class="alert-danger text-danger ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 ">
                                <label for="order" class="form-label fw-bold">Order</label>
                                <input type="text" name="order" value="{{  $question['order'] ?? old('order') }}" class="form-control" id="order" required>
                                <div class="invalid-feedback">Please enter question order!</div>
                                @error('order')
                                <div class="alert-danger text-danger ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="desc" class="form-label fw-bold">Answer</label>
                                <textarea name="desc" class="form-control tinymce-editor" cols="10" rows="3" id="desc"  required> {!! $question['desc'] ?? old('desc') !!} </textarea>
                                <div class="invalid-feedback">Please enter question answer!</div>
                                @error('desc')
                                <div class="alert-danger text-danger ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center mt-4 mb-3 d-flex justify-content-center ">
                                <button type="reset" class="btn btn-secondary bg-secondary px-5 py-2 mx-2 fw-bold">Reset</button>
                                <button type="submit" class="btn btn-success px-5 py-2 btn_theme fw-bold">Submit</button>
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

        function focusDropdown(id) {
            var element = document.getElementById(id);
            $(element).trigger('open');
        }

    });
</script>
@endPushOnce