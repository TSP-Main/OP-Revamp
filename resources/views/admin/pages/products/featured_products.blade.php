@extends('admin.layouts.default')
@section('title', 'Featured Products')
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
        <h1<a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | Featured Products</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Featured Products</li>
                </ol>
            </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <!-- Multi Columns Form -->
                        <form class="row g-3 mt-3 needs-validation" method="post" action="{{ route('admin.storeFeaturedProducts') }}" id="featuredProductForm" novalidate>
                            @csrf
                            <label for="product_id" class="form-label fw-bold">Select Product: </label>
                            <div class="row">
                                <div class="col-11  d-block">
                                    <select id="product_id" name="product_id" class="form-select select2" data-placeholder="choose product ...">
                                        <option value=""></option>
                                        @foreach ($products ?? [] as $key => $product)
                                        <option {{ isset($order['product_id']) && $product['id'] == $order['product_id'] ? 'selected' : '' }} {{ $product['id'] == old('product_id') ? 'selected' : '' }} value="{{ $product['id'] }}" data-img="{{ asset('storage/' . $product['main_image']) }}">
                                            {{ $product['title'] ?? '' }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select product!</div>
                                    @error('product_id')
                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-1 d-block text-center">
                                    <button type="button" id="add_product" class="btn btn-success  fw-semibold" style="background-color: green;">
                                        + Add
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="col-12 my-5">
                            <div class="card">
                                <div class="card-header text-center " style="background:#88888870;">
                                    <label class=" fw-bold text-dark m-0">Products Details</label>
                                </div>
                                <div class="card-body p-0 ">
                                    <table id="tbl_data" class="table table-bordered table-striped mb-0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="vertical-align: middle; text-align: center;">#</th>
                                                <th style="vertical-align: middle; padding:10px 20px;">Details</th>
                                                <th style="vertical-align: middle; text-align: center;">Price</th>
                                                <th style="vertical-align: middle; text-align: center;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($f_products ?? [] as $key => $f_product)
                                            <tr id="product_row_{{ $f_product['product']['id'] ?? '' }}">
                                                <th style="vertical-align: middle; text-align: center;">{{ $f_product['product']['id'] ?? '' }}</th>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('storage/'.$f_product['product']['main_image'])}}" class="rounded-circle" alt="no image" style="width: 45px; height: 45px" />
                                                        <div class="ms-3">
                                                            <label class="fw-semibold mb-1">{{ $f_product['product']['title'] ?? '' }}</label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: middle; text-align: center;">
                                                    <span class="fw-normal mb-1" id="price_id_{{ $f_product['product']['id'] ?? '' }}">{{ $f_product['product']['price'] ?? '' }} </span>£
                                                </td>
                                                <td style="vertical-align: middle; text-align: center;">
                                                    <a class="delete" style="cursor: pointer;" title="Delete" data-row_id="{{ $f_product['product']['id'] ?? '' }}" data-toggle="tooltip">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>



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
        var $products = @json($products);
        var total_items = 0;

        $(document).on('click', '#add_product', function() {
            var productId = $('#product_id').val();
            if (!productId) {
                alert('Please Select Product first.');
                return;
            }

            var form = $('#featuredProductForm');
            var actionUrl = form.attr('action');
            var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: {
                    _token: csrfToken,
                    product_id: productId
                },
                success: function(response) {
                    if (response.status === 'success') {
                        var product = $products[productId];
                        if (product) {
                            var imageUrl = "{{ asset('storage') }}/" + product.main_image;
                            var productHtml = `
                        <tr>
                            <th style="vertical-align: middle; text-align: center;">${product.id}</th>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="${imageUrl}" class="rounded-circle" alt="no image" style="width: 45px; height: 45px" />
                                    <div class="ms-3">
                                        <label class="fw-semibold mb-1">${product.title}</label>
                                    </div>
                                </div>
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                <span class="fw-normal mb-1" id="price_id_${product.id}">${product.price} </span>£
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                <a class="delete" style="cursor: pointer;" title="Delete" data-row_id="${product.id}" data-toggle="tooltip">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>`;
                            $('#tbl_data tbody').prepend(productHtml);
                            $('#product_id').val(null).trigger('change');
                            $('.variants').html('');
                            total_items++;
                            calculate_payment(product.price);
                        } else {
                            alert('Selected Product does not exist.');
                        }
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert('An error occurred. Please try again.');
                }
            });
        });

        $(document).on('click', '.delete', function() {
            var row_id = $(this).data('row_id');
            var token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ route("admin.deleteFeaturedProducts") }}',
                type: 'POST',
                data: {
                    _token: token,
                    product_id: row_id
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#product_row_' + row_id).fadeOut('slow', function() {
                            var product_qty = parseFloat($('#product_qty_' + row_id).val());
                            if (product_qty) {
                                let product_price = $('#price_id_' + row_id).text();
                                total_price -= parseFloat(product_price) * product_qty;
                                let price = 0;
                                total_items--;
                                calculate_payment(price);
                            }
                            $(this).remove();
                        });
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });


        function imageState(state) {
            if (!state.id) {
                return state.text;
            }
            var imgSrc = $(state.element).data('img');
            if (imgSrc) {
                var $state = $(
                    '<span><img src="' + imgSrc +
                    '" class="rounded-circle" style="width: 35px; height: 35px; margin-right: 8px;" />' +
                    state.text + '</span>'
                );
                return $state;
            } else {
                return state.text;
            }
        }

    });

    function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        var imgSrc = $(state.element).data('img');
        if (imgSrc) {
            var $state = $(
                '<span><img src="' + imgSrc +
                '" class="rounded-circle" style="width: 35px; height: 35px; margin-right: 8px;" />' + state.text +
                '</span>'
            );
            return $state;
        } else {
            return state.text;
        }
    }

    $('#product_id').select2({
        templateResult: formatState,
        templateSelection: formatState,
        width: '100%'
    });
</script>
@endPushOnce