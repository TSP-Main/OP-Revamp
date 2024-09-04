@extends('admin.layouts.default')
@section('title', 'Add Product')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css" />
<script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>

<style>
    html * {
        box-sizing: border-box;
    }

    p {
        margin: 0;
    }

    .upload__box {
        padding: 50px 0;
        min-height: 342px;
        border: 1px dotted;
        position: relative;
        background: white;
    }

    .upload__inputfile {
        width: .1px;
        height: .1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }

    .upload__btn {
        color: #fff;
        text-align: center;
        min-width: 65px;
        height: 65px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 2px solid;
        background-color: #4045ba;
        border-color: #4045ba;
        border-radius: 56px;
        line-height: 26px;
        font-size: 35px;
        position: absolute;
        top: 37%;
        font-weight: 900;
        left: 43%;
    }

    .uploaded__btn {
        color: #fff;
        text-align: center;
        min-width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 2px solid;
        background-color: #4045ba;
        border-color: #4045ba;
        border-radius: 56px;
        line-height: 26px;
        font-size: 35px;
        position: absolute;
        font-weight: 900;
        bottom: 5%;
        right: 6%;
        bottom: 9%;
    }

    .upload__btn:hover {
        background-color: unset;
        color: #4045ba;
        transition: all .3s ease;
    }

    .upload__btn-box {
        margin-bottom: 10px;
    }

    .upload__img-wrap {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }

    .upload__img-box {
        width: 200px;
        padding: 0 10px;
        margin-bottom: 12px;
    }

    .upload__img-close {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: rgba(0, 0, 0, 0.5);
        position: absolute;
        top: 10px;
        right: 10px;
        text-align: center;
        line-height: 24px;
        z-index: 1;
        cursor: pointer;
    }

    .upload__img-close:after {
        content: '\2716';
        font-size: 14px;
        color: white;
    }

    .img-bg {
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        position: relative;
        padding-bottom: 100%;
    }

    .hide {
        display: none !important;
    }
</style>
<style>
    .flip-card {
        background-color: transparent;
        width: 100px;
        height: 100px;
        perspective: 1000px;
    }

    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.6s;
        transform-style: preserve-3d;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }

    .flip-card-front,
    .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
    }

    .flip-card-front {
        background-color: #bbb;
        color: black;
    }

    .flip-card-back {
        background-color: #2980b9;
        color: white;
        transform: rotateY(180deg);
    }

    .flip-card-back {
        background-color: #2980b9;
        color: white;
        transform: rotateY(180deg);
        display: flex;
        justify-content: center;
        /* Center horizontally */
        align-items: center;
        /* Center vertically */
    }
</style>

<!-- main stated -->
<main id="main" class="main">

    <div class="pagetitle">
        <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | {{($duplicate == 'yes') ? 'Duplicate' : ( ($product['id'] ?? '') ? 'Edit' :'Add' ) }} Product</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">{{($duplicate == 'yes') ? 'Duplicate' : ( ($product['id'] ?? '') ? 'Edit' :'Add' ) }} Product</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="product-sec">
        <form class=" g-3 mt-3 needs-validation" id="product_detail_from" method="post" action="{{ route('admin.storeProduct') }}" novalidate enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{  $product['id'] ?? '' }}">
            <input type="hidden" name="duplicate" value="{{  $duplicate ?? 'no' }}">
            <div class="row gy-4">
                <div class=" col-md-6 extra-images">
                    <label class="form-label">Extra Images</label>
                    <!-- below containerrrrrrrrrrrrrrrrrrrrrrrr -->
                    <div class="upload__box">
                        <div class="upload__btn-box">
                            <div class="upload__img-wrap">
                                <label class="upload__btn" id="uploadbtn" for="product_images">
                                    <p>+</p>
                                    <input type="file" multiple data-max_length="5" id="product_images" name="images" class="upload__inputfile">
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- below containerrrrrrrrrrrrrrrrrrrrrrrr -->
                    <div style="margin-top: 10px;margin-bottom:5px">
                        <div class="row" style="padding-right: 12px;">
                            @foreach($product['product_attributes'] ?? [] as $key => $val1)
                            @php
                            $src = ($val1['image']) ? $val1['image'] : '';
                            @endphp
                            @if($src)
                            <div class="col-sm-2" id="attribute-{{ $val1['id'] }}">
                                <div class="flip-card">
                                    <div class="flip-card-inner">
                                        <div class="flip-card-front">
                                            <img src="{{ asset('storage/'.$src)}}" alt="Avatar" style="width:100px;height:100px;">
                                        </div>
                                        <div class="flip-card-back">
                                            <a href="#" class="delete-attribute" data-id="{{ $val1['id'] }}">
                                                <i class="fa fa-trash-o" style="font-size:48px;color:red"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach

                        </div>
                    </div>

                    <div class="invalid-feedback">Please select product image!</div>
                    @error('images')
                    <div class="alert-danger text-danger ">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 text-and-gallery-images">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Product Title</label>
                            <input class="form-control me-2" type="text" name="title" id="title" value="{{  $product['title'] ?? old('title') }}" placeholder="Product Title" aria-label="Search" required>
                            <div class="invalid-feedback">Please write product title!</div>
                            @error('title')
                            <div class="alert-danger text-danger ">{{ $message }}</div>
                            @enderror
                        </div>
                        @php
                        $path = url('assets/admin/img/upload_btn.png');
                        if($product['main_image'] ?? NULL){
                        $path = asset('storage/'.$product['main_image']);
                        }
                        @endphp
                        <div class="col-12 mt-2 produt-main-image">
                            <label for="product_main_image" class="form-label">Upload Main Image</label>
                            <div class="d-flex align-items-center" style="gap: 20px; justify-content: space-between;">
                                <input type="file" class="form-control w-100" id="product_main_image" name="main_image" value="{{ ($product['main_image'] ?? NULL) ? 'required' : '' }}" onchange="previewMainImage(this)">
                                <label for="product_main_image" class=" d-block ">
                                    <img id="mainImage_preview" src="{{  $path ?? '' }}" class="rounded-circle" alt="no image" style="width: 45px; height: 45px;  cursor:pointer;   object-fit: cover;">
                                </label>
                            </div>
                            <div class="invalid-feedback">* Upload product main Image!</div>
                        </div>
                        <div class="col-12 select-product-category">
                            <label for="category_id" class="form-label">Select Product Category</label>
                            <select id="category_id" name="category_id" class="form-select" required>
                                <option value="" selected>Choose...</option>
                                @foreach ($categories as $key => $value)
                                <option value="{{ $value['id'] ?? '' }}" {{ (isset($product['category_id']) && $product['category_id'] == $value['id']) ? 'selected' : '' }}>{{ $value['name'] ?? '' }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">* Please select product category</div>
                        </div>
                        <div class="col-12 select-sub_category">
                            <label for="sub_category" class="form-label">Select Sub Category</label>
                            <select id="sub_category" name="sub_category" class="form-select">
                                @if(@isset($sub_category))
                                <option value="" selected>Choose...</option>
                                @foreach ($sub_category as $key => $value)
                                <option value="{{ $key ?? '' }}" {{ (isset($product['sub_category']) && $product['sub_category'] == $key) ? 'selected' : '' }}>{{ $value ?? '' }}</option>
                                @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">* Please select sub category</div>
                        </div>
                        <div class="col-12 select-child_category">
                            <label for="child_category" class="form-label">Select Child Category</label>
                            <select id="child_category" name="child_category" class="form-select">
                                @if(@isset($child_category))
                                @foreach ($child_category as $key => $value)
                                <option value="{{ $key ?? '' }}" {{ (isset($product['child_category']) && $product['child_category'] == $key) ? 'selected' : '' }}>{{ $value ?? '' }}</option>
                                @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">* Please select child category</div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="product_template" class="col-form-label"> Select Template <span class="product-template"></span></label>
                    <select id="product_template" name="product_template" class="form-select" required>
                        <option value="" selected>Choose...</option>
                        @foreach ($templates as $key => $value)
                        <option value="{{ $key ?? '' }}" {{ (isset($product['product_template']) && $product['product_template'] == $key) ? 'selected' : '' }}>{{ $value ?? '' }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Select Template!</div>
                    @error('product_template')
                    <div class="alert-danger text-danger ">{{ $message }}</div>
                    @enderror
                </div>

                @php
                $display = isset($product['product_template']) ? ($product['product_template'] == config('constants.PRESCRIPTION_MEDICINE') ? '' : 'd-none') : '';
                @endphp
                <div class="col-md-6 question_category-div {{$display}}">
                    <label for="question_category" class="col-form-label"> Select Question Category <span class="question-category"></span></label>
                    <select id="question_category" name="question_category[]" class="form-select select2 py-1" data-placeholder="choose categories ...">
                        <option value="choose">choose</option>
                        @foreach ($question_category as $key => $value)
                        <option value="{{ $value['id'] ?? '' }}" {{ (isset($prod_question) && in_array($value['id'], $prod_question)) ? 'selected' : '' }}>{{ $value['name'] ?? '' }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Select Question Category!</div>
                    @error('product_template')
                    <div class="alert-danger text-danger ">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="cut_price" class="col-form-label"> Cut Price <span class="cut-price"></span></label>
                    <input type="text" name="cut_price" id="cut_price" value="{{  $product['cut_price'] ?? old('cut_price') }}" class="form-control">
                    <div class="invalid-feedback">Enter Cut Price!</div>
                    @error('cut_price')
                    <div class="alert-danger text-danger ">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="price" class="col-form-label"> Price <span class="extra-text">(Price in UK Pound)</span></label>
                    <input type="text" name="price" id="price" value="{{  $product['price'] ?? old('price') }}" class="form-control" required>
                    <div class="invalid-feedback">Enter product price!</div>
                    @error('price')
                    <div class="alert-danger text-danger ">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="stock" class="col-form-label">Inventory <span class="extra-text">(Available Stock)</span></label>
                    <input type="number" id="stock" name="stock" value="{{  $product['stock'] ?? old('stock') }}" class="form-control" required>
                    <div class="invalid-feedback">Enter product stock!</div>
                    @error('stock')
                    <div class="alert-danger text-danger ">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="stock" class="col-form-label">SKU </label>
                    <input type="text" name="SKU" id="SKU" value="{{  $product['SKU'] ?? old('SKU') }}" class="form-control">
                    <div class="invalid-feedback">Enter avialable stock!</div>
                    @error('SKU')
                    <div class="alert-danger text-danger ">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mt-2">
                    <label for="barcode" class="form-label">Barcode (ISBN, UPC, GTIN, etc.)</label>
                    <input type="text" name="barcode" id="barcode" value="{{  $product['barcode'] ?? old('barcode') }}" class="form-control">
                    <div class="invalid-feedback">Enter GTIN number!</div>
                    @error('barcode')
                    <div class="alert-danger text-danger ">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mt-2">
                    <label for="weight" class="form-label">Weight (gm) - If Weight is zero, enter '0' (not '0.0')</label>
                    <input type="text" name="weight" id="weight" value="{{  $product['weight'] ?? old('weight') }}" class="form-control">
                    <div class="invalid-feedback">Enter product weight!</div>
                    @error('weight')
                    <div class="alert-danger text-danger ">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="stock_status" class="col-form-label"> Stock Status </label>
                    <select id="stock_status" name="stock_status" class="form-select" required>
                        <option value="IN" {{ (isset($product['stock_status']) && $product['stock_status'] == 'IN') ? 'selected' : '' }}>IN</option>
                        <option value="OUT" {{ (isset($product['stock_status']) && $product['stock_status'] == 'OUT') ? 'selected' : '' }}>OUT</option>
                    </select>
                    <div class="invalid-feedback">Select Stock Status!</div>
                    @error('stock_status')
                    <div class="alert-danger text-danger ">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            </div>
            <div class="row mb-5">
                <div class="form-floating col-12  mt-3">
                    <textarea class="form-control tinymce-editor" name="short_desc" id="short_desc" placeholder="Product short Description">{{$product['short_desc'] ?? ''}}</textarea>
                    <div class="invalid-feedback">Please write product short desc!</div>
                    @error('short_desc')
                    <div class="alert-danger text-danger ">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-5">
                <div class="form-floating col-12  mt-3">
                    <textarea class="form-control tinymce-editor" name="desc" id="pro_desc" placeholder="Product main Description" required=''>{{$product['desc'] ?? ''}}</textarea>
                    <div class="invalid-feedback">Please write product Main desc!</div>
                    @error('desc')
                    <div class="alert-danger text-danger ">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            {{-- Variant Section --}}
            <div class="container-fluid m-0 ">
                <div class="d-flex justify-content-between col-md-12 align-items-center">
                    <div class="variants-div">
                        <h4 class="fw-bold">Product Variants</h4>
                    </div>
                    <div class=" float-end">
                        <div class="p-2">
                            <lable id="add_new_row" class="btn btn-success mb-2"><i class="fa fa-plus"></i> Add Variants</lable>
                        </div>
                    </div>
                </div>
                {{-- existing variants --}}
                <div id="variant_row_existing">
                    @if(isset($product['variants']))
                    @foreach ($product['variants'] as $variant)
                    <div class="row bg-white rounded-3  mb-4 py-2" id="variant_{{ $variant['id'] }}">
                        <input type="hidden" value="{{$variant['id']}}" name="exist_vari_id[]">
                        <div class="col-12">
                            <hr class="">
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="p-2">
                                <label for="" class="form-label">Variant Price <span class="vari-price">(Price in UK Pound)</span></label>
                                <input type="text" class="form-control" name="exist_vari_price[]" id="" value="{{ $variant['price']}}" required>
                                <div class="invalid-feedback">Enter variant price!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="p-2">
                                <label for="" class="form-label">Variant Cut Price <span class="vari-cut-price">(Price in UK Pound)</span></label>
                                <input type="text" class="form-control" name="exist_vari_cut_price[]" id="" value="{{ $variant['cut_price']}}">
                                <div class="invalid-feedback">Enter variant cut price!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="p-2">
                                <label for="" class="form-label">Variant Name <span class="extra-text"></span></label>
                                <input type="text" class="form-control" name="exist_vari_name[]" id="" value="{{ $variant['title']}}" required>
                                <div class="invalid-feedback">Enter variant title!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 product-md">
                            <div class="p-2">
                                <label for="" class="form-label">Variant Value <span class="extra-text"></span></label>
                                <input type="text" class="form-control" name="exist_vari_value[]" id="" value="{{ $variant['value']}}" required>
                                <div class="invalid-feedback">Enter variant value!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 ">
                            <div class="p-2">
                                <label for="" class="form-label">Inventory <span class="extra-text">(Available Stock)</span></label>
                                <input type="number" class="form-control" name="exist_vari_inventory[]" id="" value="{{ $variant['inventory']}}" required>
                                <div class="invalid-feedback">Enter variant stock!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 ">
                            <div class="p-2">
                                <label for="" class="form-label">weight <span class="extra-text">(gm)</span></label>
                                <input type="text" class="form-control" name="exist_vari_weight[]" id="" value="{{ $variant['weight'] }}">
                                <div class="invalid-feedback">Enter variant weight!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="p-2">
                                <label for="" class="form-label">Barcode <span class="extra-text">(ISBN, UPC, GTIN, etc.)</span></label>
                                <input type="text" class="form-control" name="exist_vari_barcode[]" id="" value="{{ $variant['barcode']}}">
                                <div class="invalid-feedback">Enter variant barcode!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="p-2">
                                <label for="" class="form-label">SKU <span class="extra-text">(Stock Keeping Unit)</span></label>
                                <input type="text" class="form-control" name="exist_vari_sku[]" id="" value="{{ $variant['sku']}}">
                                <div class="invalid-feedback">Enter variant stock!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 ">
                            <div class="p-2">
                                <label class="form-label">Select Image</label>
                                <input class="form-control variant-image-exist" name="exist_vari_attr_image[]" type="file" id="">
                                <div class="invalid-feedback">Enter variant image!</div>
                            </div>
                        </div>
                        <div class="col-md-12 d-flex justify-content-end col-sm-12 mt-4 ">
                            <div class="p-2 ">
                                <button type="button" class="btn delete-variant btn-danger bg-danger" data-id="{{ $variant['id'] }}" data-token="{{ csrf_token() }}"><i class="fa fa-minus"></i> Remove</button>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr class="">
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                <div id="variant_row">

                </div>
            </div>
            <div class="product-btns mt-4 text-end px-4 d-flex d-md-block">
                <input type="reset" class=" btn btn-secondary bg-secondary rounded-2  px-5 mx-1 fw-bold" value="Cancel">
                <button class="rounded-2 py-2 px-5 fw-bold mt-0">Submit</button>
            </div>

            </div>
        </form>
    </section>

</main>
<!-- End #main -->

@stop

@pushOnce('scripts')
<script>
    jQuery(document).ready(function() {
        ImgUpload();

        $('#category_id').change(function() {
            var category_id = $(this).val();
            $('#sub_category').empty();
            $('#child_category').empty();
            $.ajax({
                url: '{{ route("admin.getSubCategory") }}',
                type: 'GET',
                data: {
                    category_id: category_id
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#sub_category').empty();
                        $.each(response.sub_category, function(key, value) {
                            $('#sub_category').append($('<option>', {
                                value: key,
                                text: value
                            }));
                        });
                        $('#sub_category').prepend($('<option>', {
                            value: '',
                            text: 'Select Sub Category',
                            selected: true,
                            disabled: true
                        }));
                    } else {
                        console.error('Error:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $('#sub_category').change(function() {
            var category_id = $(this).val();
            $.ajax({
                url: '{{ route("admin.getChildCategory") }}',
                type: 'GET',
                data: {
                    category_id: category_id
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#child_category').empty();
                        $.each(response.child_category, function(key, value) {
                            $('#child_category').append($('<option>', {
                                value: key,
                                text: value
                            }));
                        });
                        $('#child_category').prepend($('<option>', {
                            value: '',
                            text: 'Select Child Category',
                            selected: true,
                            disabled: true
                        }));
                    } else {
                        console.error('Error:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $('#product_template').change(function() {
            var template = $(this).val();
            if (template == 2) {
                $('.question_category-div').removeClass('d-none');
            } else {
                $('.question_category-div').addClass('d-none');
            }
        });

        $('.delete-variant').on('click', function() {
            var id = $(this).data("id");
            var token = $(this).data("token");

            var confirmDelete = confirm("Are you sure you want to delete this variant?");
            if (!confirmDelete) {
                return false;
            }

            $.ajax({
                url: "{{route('admin.deleteVariant')}}",
                type: 'DELETE',
                dataType: "JSON",
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        alert(response.message);
                        $('#variant_' + id).remove();
                    }
                }
            });
        });
    });

    var imgArray = [];

    function ImgUpload() {
        var imgWrap = $('.upload__img-wrap');
        var maxLength = $('.upload__inputfile').attr('data-max_length');

        $('.upload__inputfile').on('change', function(e) {
            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);

            for (var i = 0; i < filesArr.length; i++) {
                if (!filesArr[i].type.match('image.*')) {
                    continue;
                }

                imgArray.push(filesArr[i]);

                var reader = new FileReader();
                reader.onload = function(e) {
                    var html =
                        "<div class='upload__img-box'><div style='background-image: url(" +
                        e.target.result + ")' data-number='" + imgArray.length +
                        "' data-file='" + imgArray[imgArray.length - 1].name +
                        "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                    $('#uploadbtn').removeClass('upload__btn').addClass('uploaded__btn');
                    imgWrap.prepend(html);
                };

                reader.readAsDataURL(filesArr[i]);
            }
        });

        $('body').on('click', ".upload__img-close", function(e) {
            var file = $(this).parent().data("file");
            imgArray = imgArray.filter(function(img) {
                return img.name !== file;
            });
            $(this).parent().parent().remove();
        });

        $('body').on('submit', '#product_detail_from', function(e) {
            e.preventDefault();

            // Create FormData object
            var formData = new FormData();
            // Append main image
            formData.append('main_image', $('#product_main_image')[0].files[0]);
            // Append variant images
            $('.variant-image').each(function(index, element) {
                formData.append('vari_attr_images[]', element.files[0]);
            });
            // Append variant images Existing
            $('.variant-image-exist').each(function(index, element) {
                var variantId = $(element).closest('.row').find('input[name="exist_vari_id[]"]').val();
                formData.append('exist_vari_attr_images[' + variantId + ']', element.files[0]);
            });
            // Append images to the FormData object
            for (var i = 0; i < imgArray.length; i++) {
                formData.append('images[]', imgArray[i]);
            }

            // Append other form data
            $(this).serializeArray().forEach(function(field) {
                formData.append(field.name, field.value);
            });

            // Submit the form with AJAX
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        window.location.href = "{{ route('admin.prodcuts') }}";
                    } else if (response.status === 'error') {

                        console.log(response.message);
                        $('.error-label').remove();

                        $.each(response.message, function(field, errorMessages) {
                            var inputField = $('input[name="' + field + '"]');

                            $.each(errorMessages, function(index, errorMessage) {
                                var errorLabel = $('<label class="error-label text-danger">* ' + errorMessage + '</label>');
                                inputField.addClass('error');
                                inputField.after(errorLabel);
                            });
                        });
                    }

                },
                error: function(error) {
                    alert('technical error occur')
                }
            });
        });

        $('input').on('input', function() {
            $(this).removeClass('error');
            $(this).next('.error-label').remove();
        });

        $('select').on('change', function() {
            $(this).removeClass('error');
            $(this).next('.error-label').remove();
        });

    }

    function previewMainImage(input) {
        var preview = $('#mainImage_preview');
        var file = input.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            preview.attr('src', e.target.result);
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    // new row add 
    var new_row = `<div class="row bg-white rounded-3  mb-4 py-2">
                        <div class="col-12">
                            <hr class="">
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="p-2">
                                <label for="" class="form-label">Variant Price <span class="extra-text">(Price in UK Pound)</span></label>
                                <input type="text" class="form-control" name="vari_price[]" id="" required>
                                <div class="invalid-feedback">Enter variant price!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="p-2">
                                <label for="" class="form-label">Variant Cut Price <span class="extra-text">(Price in UK Pound)</span></label>
                                <input type="text" class="form-control" name="vari_cut_price[]" id="">
                                <div class="invalid-feedback">Enter variant cut price!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="p-2">
                                <label for="" class="form-label">Variant Name <span class="extra-text"></span></label>
                                <input type="text" class="form-control" name="vari_name[]" id="" required>
                                <div class="invalid-feedback">Enter variant title!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 product-md">
                            <div class="p-2">
                                <label for="" class="form-label">Variant Value <span class="extra-text"></span></label>
                                <input type="text" class="form-control" name="vari_value[]" id="" required>
                                <div class="invalid-feedback">Enter variant value!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 ">
                            <div class="p-2">
                                <label for="" class="form-label">Inventory <span class="extra-text">(Available Stock)</span></label>
                                <input type="number" class="form-control" name="vari_inventory[]" id="" required>
                                <div class="invalid-feedback">Enter variant stock!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="p-2">
                                <label for="" class="form-label">Weight <span class="extra-text">(gm)</span></label>
                                <input type="text" class="form-control" name="vari_weight[]" id="" >
                                <div class="invalid-feedback">Enter variant weight!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="p-2">
                                <label for="" class="form-label">Barcode <span class="extra-text">(ISBN, UPC, GTIN, etc.)</span></label>
                                <input type="text" class="form-control" name="vari_barcode[]" id="" >
                                <div class="invalid-feedback">Enter variant barcode!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="p-2">
                                <label for="" class="form-label">SKU <span class="extra-text">(Stock Keeping Unit)</span></label>
                                <input type="text" class="form-control" name="vari_sku[]" id="" >
                                <div class="invalid-feedback">Enter variant stock!</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 ">
                            <div class="p-2">
                                <label  class="form-label">Select Image</label>
                                <input class="form-control variant-image" name="vari_attr_image[]" type="file" id="">
                                <div class="invalid-feedback">Enter variant image!</div>
                            </div>
                        </div>
                        <div class="col-md-12 d-flex justify-content-end col-sm-12 mt-4 ">
                            <div class="p-2 ">
                                <button type="button" class="btn remove_row btn-danger bg-danger"><i class="fa fa-minus"></i> Remove</button>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr class="">
                        </div>
                    </div>`;

    $('#add_new_row').on('click', function() {
        $('#variant_row').append(new_row);
    });

    $(document).on('click', '.remove_row', function() {
        $(this).closest('.row').fadeOut('slow', function() {
            $(this).remove();
        });
    });

    $(document).on('click', '.delete-attribute', function(e) {
        e.preventDefault();
        var attributeId = $(this).data('id');

        $.ajax({
            url: "{{ route('admin.deleteProductAttribute') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id: attributeId
            },
            success: function(response) {
                if (response.status == 'success') {
                    $('#attribute-' + attributeId).fadeOut('slow', function() {
                        $(this).remove();
                    });
                    // alert('image is deleted.')
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('An error occurred while trying to delete the attribute.');
            }
        });
    });
</script>
@endPushOnce