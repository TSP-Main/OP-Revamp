@extends('admin.layouts.default')
@section('title', 'Create Discount')
@section('content')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Ensure product and category input fields have the same size */
.select2-container .select2-selection--single {
    height: 40px !important;
    width: 100% !important; /* Ensure full width for consistency */
}

.select2-selection__rendered {
    line-height: 35px !important;
}

.select2-selection__arrow {
    height: 40px !important;
}

.form-select {
    /* border-radius: 30px; */
    height: 40px !important; /* Set the height of the select inputs */
    padding: 0.375rem 1.25rem !important;
    font-size: 1rem;
    border: 1px solid #ccc !important;
    transition: all 0.3s ease;
}

.select2-container {
    width: 100% !important; /* Ensure the select2 container stretches to the available width */
}

.form-control {
    height: 40px !important; 
    border-radius: 5px !important/* Consistent height for all form controls */
}


    .form-check-input:checked + .form-check-label {
        border: 2px solid #1AA7C0;
        box-shadow: 0 0 0 2px rgba(26, 167, 192, 0.25);
    }

    .form-check-label {
        display: inline-block;
        padding: 10px 20px;
        border: 1px solid #ccc;
        border-radius: 30px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .form-check-input:checked + .form-check-label {
        background-color: #1AA7C0;
        color: white;
        font-weight: bold;
    }

    .form-check-input {
        margin-top: 10px;
    }

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
        background: #1AA7C0;
        border: #1AA7C0 1px solid;
    }

    .btn:hover {
        background: #577BBF;
        border: #577BBF 1px solid;
    }

    .hide {
        display: none;
    }

    .card-header {
        background-color: #1AA7C0;
        color: white;
        border-radius: 10px 10px 0 0;
        text-align: center;
    }

    .card-body {
        background: #f8f9fa;
        border-radius: 0 0 10px 10px;
        padding: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control {
        border-radius: 30px;
        border: 1px solid #ccc;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #1AA7C0;
        box-shadow: 0 0 5px rgba(26, 167, 192, 0.5);
    }

    .btn-success {
        background-color: #1AA7C0;
        border: 1px solid #1AA7C0;
        color: white;
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    .btn-success:hover {
        background-color: #577BBF;
        border: 1px solid #577BBF;
    }

    .breadcrumb-item {
        color: #1AA7C0;
    }

    .breadcrumb-item.active {
        color: #577BBF;
    }

    .alert {
        border-radius: 10px;
        padding: 15px;
        font-size: 1rem;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

</style>
<!-- main stated -->
<main id="main" class="main">
    <div class="pagetitle">
        <h1>
            <a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-outline-primary fw-bold">
                <i class="bi bi-arrow-left"></i> Back
            </a> | Create Discount Code
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Create Discount</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12 mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <label class="fw-bold m-0">Discount Details</label>
                                </div>
                                <form action="{{ route('admin.storeDiscount') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="discount_id" value="{{ $discount->id ?? '' }}"> <!-- Hidden field for discount_id -->
                                    <div class="card-body p-0">
                                        <div class="col-12 px-4 mt-3 mb-4">
                                            <h5 class="fw-bold" style="text-decoration: underline;">Discount Information:</h5>
                                
                                            <div class="row">
                                                <div class="col-md-6 col-12 mb-3">
                                                    <label for="code" class="form-label">Discount Code</label>
                                                    <div class="input-group">
                                                        <input type="text" id="code" name="code" class="form-control" value="{{ old('code', $discount->code ?? '') }}" placeholder="Enter or generate discount code">
                                                        <button type="button" class="btn btn-outline-primary" id="generate_code_btn">
                                                            <i class="bi bi-arrow-clockwise"></i> Generate
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="selection_type" id="product_based" value="product" checked>
                                                <label class="form-check-label" for="product_based">Product Based</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="selection_type" id="category_based" value="category">
                                                <label class="form-check-label" for="category_based">Category Based</label>
                                            </div>

                                            <div id="product_section" style="display:block;">
                                                <label for="product_id" class="form-label fw-bold">Select Product:</label>
                                                <div class="row">
                                                    <div class="col-8 d-block mb-5">
                                                        <select id="product_id" name="product_id" class="form-select select2" data-placeholder="Choose product...">
                                                            <option value=""></option>
                                                            @foreach ($products ?? [] as $key => $product)
                                                                <option value="{{ $product['id'] }}" data-img="{{ asset('storage/' . $product['main_image']) }}">
                                                                    {{ $product['title'] ?? '' }} Price:{{ $product['price'] ?? '' }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                             <!-- Variant Section -->
                                                <div id="variant_section" style="display:block;">
                                                    <label for="variant_id" class="form-label fw-bold">Select Variant:</label>
                                                    <div class="row">
                                                        <div class="col-8 d-block mb-5">
                                                            <select id="variant_id" name="variant_id" class="form-select select2" data-placeholder="Choose variant...">
                                                                <option value="">Choose a variant...</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div id="category_section" style="display:none;">
                                                <div class="col-md-6 mt-2">
                                                    <label for="category_id" class="form-label">Choose Category:</label>
                                                    <div class="row">
                                                        <div class="col-11 d-block mb-5">
                                                            <select id="category_id" name="category_id" class="form-select select2" data-placeholder="Choose category...">
                                                                <option value=""></option>
                                                                @foreach ($categories ?? [] as $category)
                                                                    <option value="{{ $category->id }}">
                                                                        {{ $category->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-11 d-block mb-5" id="sub_category_container" style="display:none;">
                                                            <select id="sub_category_id" name="sub_category_id" class="form-select select2" data-placeholder="Choose sub-category...">
                                                                <option value="">Choose sub-category...</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-11 d-block mb-5" id="child_category_container" style="display:none;">
                                                            <select id="child_category_id" name="child_category_id" class="form-select select2" data-placeholder="Choose child category...">
                                                                <option value="">Choose child category...</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <h5 class="fw-bold mt-4">Discount Settings</h5>
                                            <div class="row">
                                                <div class="col-md-6 col-12 mb-3">
                                                    <label for="discount_type" class="form-label">Discount Type</label>
                                                    <select id="discount_type" name="discount_type" class="form-select select2">
                                                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                                        <option value="fixed_amount" {{ old('discount_type') == 'fixed_amount' ? 'selected' : '' }}>Fixed Amount</option>
                                                        <option value="free_shipping" {{ old('discount_type') == 'free_shipping' ? 'selected' : '' }}>Free Shipping</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 col-12 mb-3" id="value_field">
                                                    <label for="value" class="form-label">Value</label>
                                                    <input type="number" id="value" name="value" class="form-control" value="{{ old('value') }}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="max_usage" class="form-label">Max Usage</label>
                                                    <input type="number" id="max_usage" name="max_usage" class="form-control" value="{{ old('max_purchase') }}">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="max_usage_per_user" class="form-label">Max Usage Per User</label>
                                                    <input type="number" id="max_purchase_per_user" name="max_purchase_per_user" class="form-control" value="{{ old('max_purchase_per_user') }}">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="min_purchase_amount" class="form-label">Min Purchase Amount</label>
                                                    <input type="number" id="min_purchase_amount" name="min_purchase_amount" class="form-control" value="{{ old('min_purchase_amount') }}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="start_date" class="form-label">Start Date</label>
                                                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="start_time" class="form-label">Start Time</label>
                                                    <input type="time" id="start_time" name="start_time" class="form-control" value="{{ old('start_time') }}">
                                                </div>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="end_date_toggle" name="end_date_toggle" {{ old('end_date_toggle') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="end_date_toggle">Enable End Date</label>
                                            </div>

                                            <div id="end_date_section" style="display: none;">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="end_date" class="form-label">End Date</label>
                                                        <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="end_time" class="form-label">End Time</label>
                                                        <input type="time" id="end_time" name="end_time" class="form-control" value="{{ old('end_time') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-1 d-block text-center">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@stop
@pushOnce('scripts')
<script>
   document.addEventListener('DOMContentLoaded', function () {
    // Initialize Select2
    $('#category_id, #sub_category_id, #child_category_id').select2();

    // Handle category change to populate sub-categories
    $('#category_id').on('change', function () {
        const categoryId = $(this).val();
        const subCategorySelect = $('#sub_category_id').empty().append('<option value="">Choose sub-category...</option>');
        const childCategorySelect = $('#child_category_id').empty().append('<option value="">Choose child category...</option>');

        $('#sub_category_container, #child_category_container').hide();

        if (categoryId) {
            fetch(`/admin/SubCategoryDiscount?category_id=${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length) {
                        $('#sub_category_container').show();
                        data.forEach(subCategory => {
                            subCategorySelect.append(new Option(subCategory.name, subCategory.id));
                        });
                    }
                })
                .catch(() => {});
        }
    });

    // Handle sub-category change to populate child categories
    $('#sub_category_id').on('change', function () {
        const subCategoryId = $(this).val();
        const childCategorySelect = $('#child_category_id').empty().append('<option value="">Choose child category...</option>');
        $('#child_category_container').hide();

        if (subCategoryId) {
            fetch(`/admin/ChildCategoryDiscount?sub_category_id=${subCategoryId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length) {
                        $('#child_category_container').show();
                        data.forEach(childCategory => {
                            childCategorySelect.append(new Option(childCategory.name, childCategory.id));
                        });
                    }
                })
                .catch(() => {});
        }
    });
            // Handle product change to populate variants
            $('#product_id').on('change', function () {
                const productId = $(this).val();
                const variantSelect = $('#variant_id').empty().append('<option value="">Choose variant...</option>');
                
                if (productId) {
                    // Make the API call to fetch variants for the selected product
                    fetch(`/admin/VariantsDiscount?product_id=${productId}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Variants data:', data); // Log the data to check its structure
                            
                            if (data.length) {
                                data.forEach(variant => {
                                    // Create a variant name using title and value
                                    const variantName = `${variant.title} - ${variant.value} - Price ${variant.price}`;
                                    
                                    // Append the option to the select dropdown
                                    variantSelect.append(new Option(variantName, variant.id));
                                });
                                
                                // Reinitialize Select2 after appending options
                                $('#variant_id').trigger('change').select2();
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching variants:', error);
                        });
                }
            });
            // Toggle product and category sections
            $('#product_based').on('change', function () {
                $('#product_section').toggle(this.checked);
                $('#category_section').hide();
            });
            $('#category_based').on('change', function () {
                $('#category_section').toggle(this.checked);
                $('#product_section').hide();
            });

            // Toggle End Date section visibility
            $('#end_date_toggle').on('change', function () {
                $('#end_date_section').toggle(this.checked);
            });

            // Generate discount code
            $('#generate_code_btn').on('click', function () {
                $('#code').val(generateDiscountCode());
            });

            // Function to generate a random 8-character alphanumeric code
            function generateDiscountCode() {
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
                let code = 'OP4U-';
                for (let i = 0; i < 8; i++) {
                    code += characters.charAt(Math.floor(Math.random() * characters.length));
                }
                return code;
            }

             // Disable or enable the value field based on the selected discount type
            // $('#discount_type').on('change', function () {
            //     const discountType = $(this).val();
            //     const valueField = $('#value_field');
                
            //     if (discountType === 'free_shipping') {
            //         // Disable the value field if Free Shipping is selected
            //         valueField.find('input').prop('disabled', true);
            //     } else {
            //         // Enable the value field if other discount types are selected
            //         valueField.find('input').prop('disabled', false);
            //     }
            // }).trigger('change');
    
    });
</script>
@endPushOnce
