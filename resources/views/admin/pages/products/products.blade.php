@extends('admin.layouts.default')
@section('title', 'Products')
@section('content')
<!-- main stated -->
<main id="main" class="main">

    <style>
        .edit i {
            color: #4154F1;
            font-size: 20px;
            margin-right: 10px;
            margin-left: 10px;
        }

        .delete i {
            color: #E34724;
            font-size: 20px;
            margin-left: 10px;
        }

        .card-body table tr {
            background-color: #E34724 !important;
        }

        /* Custom CSS for DataTables buttons */
        .btn-blue {
            background-color: blue !important;
            color: white !important;
            border: none !important;
            border-radius: 5px !important;
            margin-right: 5px;
            font-weight: bold;
        }

        .btn-blue:hover {
            background-color: darkblue !important;
        }

        .table-stripe tbody tr:nth-child(odd) {
            background-color: lightblue;
        }

        .table-stripe tbody tr:nth-child(even) {
            background-color: deepskyblue;
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
            background: #03bd8d;
            border: #03bd8d 1px solid;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
            visibility: hidden;
        }

        #snackbar {
            visibility: hidden;
            /* Hidden by default. Visible on click */
            min-width: 250px;
            /* Set a default minimum width */
            margin-left: -125px;
            /* Divide value of min-width by 2 */
            background-color: #dc3545;
            /* Black background color */
            color: #fff;
            /* White text color */
            text-align: center;
            /* Centered text */
            border-radius: 2px;
            /* Rounded borders */
            padding: 16px;
            /* Padding */
            position: fixed;
            /* Sit on top of the screen */
            z-index: 1;
            /* Add a z-index if needed */
            left: 70%;
            /* Center the snackbar */
            bottom: 50%;
            /* 30px from the bottom */
        }

        /* Show the snackbar when clicking on a button (class added with JavaScript) */
        #snackbar.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        /* Animations to fade the snackbar in and out */
        @-webkit-keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }

            to {
                bottom: 50%;
                opacity: 1;
            }
        }

        @keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }

            to {
                bottom: 50%;
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeout {
            from {
                bottom: 50%;
                opacity: 1;
            }

            to {
                bottom: 0;
                opacity: 0;
            }
        }

        @keyframes fadeout {
            from {
                bottom: 50%;
                opacity: 1;
            }

            to {
                bottom: 0;
                opacity: 0;
            }
        }
    </style>

    <div class="pagetitle">
        <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | Products</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="col-md-12 align-right mt-2 d-block">
            <button id="export_csv" class=" btn btn-success">Export CSV</button>
        </div>
        <div class="row">
                    <div class="card-header mt-3" id="tbl_buttons" style="border: 0 !important; border-color: transparent !important;"></div>
                    <div class="row mb-3 px-4">
                        <div class="col-md-4  mt-2 d-block">
                            <label for="category" class="form-label fw-bold">Filter by Category</label>
                            <select id="category" class="form-select select2" data-placeholder="search category...">
                                <option value="All">All</option>
                                @foreach ($filters['categories'] ?? [] as $key => $category)
                                <option value="{{$category}}">{{$category}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4  mt-2 d-block">
                            <label for="sub_category" class="form-label fw-bold">Filter by Sub Category</label>
                            <select id="sub_category" class="form-select select2" data-placeholder="search sub category...">
                                <option value="All">All</option>
                                @foreach ($filters['sub_cat'] ?? [] as $key => $sub_category)
                                <option value="{{$sub_category}}">{{$sub_category}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4  mt-2 d-block">
                            <label for="child_category" class="form-label fw-bold">Filter by Child Category</label>
                            <select id="child_category" class="form-select select2" data-placeholder="search child category...">
                                <option value="All">All</option>
                                @foreach ($filters['child_cat'] ?? [] as $key => $child_category)
                                <option value="{{$child_category}}">{{$child_category}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4  mt-2 d-block">
                            <label for="title" class="form-label fw-bold">Filter by Title</label>
                            <select id="title" class="form-select select2" data-placeholder="search title...">
                                <option value="All">All</option>
                                @foreach ($filters['titles'] ?? [] as $key => $title)
                                <option value="{{$title}}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4  mt-2 d-block">
                            <label for="template" class="form-label fw-bold">Filter by Template</label>
                            <select id="template" class="form-select select2" data-placeholder="search template...">
                                <option value="All">All</option>
                                @foreach ($filters['templates'] ?? [] as $key => $template)
                                <option value="{{config('constants.PRODUCT_TEMPLATES')[$template]}}"> {{config('constants.PRODUCT_TEMPLATES')[$template]}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 text-center mt-2 d-block">
                            <label for="endDate" class="form-label fw-bold">Trash</label>
                            <a href="{{route('admin.proTrash')}}" class="form-control btn btn-success py-2 fw-bold">Go to Trash</a>
                        </div>
                        <div class="col-md-8 mt-3 text-center d-block">
                            <label for="search" class="form-label fw-bold">Search From Table </label>
                            <input type="text" id="search_text" placeholder="Search here..." class="form-control py-2 search_text">

                        </div>
                        <div class="col-md-4 mt-4 text-center d-block">
                        <label for="search" class="form-label fw-bold"></label>
                        <button id="search_btn" class="form-control btn btn-success py-2 fw-bold search_btn">Search</button>
                        </div>
                        {{-- <div class="col-md-2 mt-4 text-center d-block">
                            <label for="search" class="form-label fw-bold"></label>
                            <button class="form-control btn btn-success py-2 fw-bold clear_btn">Clear</button>
                        </div> --}}
                    </div>

                    <div class="card-body">
                        <table id="example" class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Details</th>
                                    <th>Price - Ext_Tax</th>
                                    <th>Inventory <span class="extra-text">(Available Stock)</span></th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Child Category</th>
                                    <th>Template</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between">
                            <div>
                                {{-- <p>Total Entries: {{ $products->total() }}</p> --}}
                            </div>
                            <div>
                                {{-- {{ $products->links() }} --}}
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>

</main>
<!-- End #main -->
<form id="edit_form" action="{{route('admin.addProduct')}}" method="post">
    @csrf
    <input id="edit_form_id_input" type="hidden" value="" name="id">
    <input id="duplicate" type="hidden" value="no" name="duplicate">
</form>
<!-- End #main -->
<div id="snackbar" class="fw-bold">Product Deleted Successfully.</div>

@stop

@pushOnce('scripts')
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.products') }}",
                data: function(d) {
                    d.title = $('#search_text').val();
                    // d.category_id = $('#category').val();
                    // d.sub_cat_id = $('#sub_cat').val();
                    // d.child_cat_id = $('#child_cat').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'details', name: 'details', orderable: false, searchable: false },
                { data: 'price', name: 'price' },
                { data: 'stock', name: 'stock' },
                { data: 'category.name', name: 'category.name' },
                { data: 'sub_cat.name', name: 'sub_cat.name' },
                { data: 'child_cat.name', name: 'child_cat.name' },
                { data: 'product_template', name: 'product_template' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions' },

            ],
            columnDefs: [
                {
                    targets: 6, // Adjust based on the column index
                    render: function(data, type, row) {
                        return data ? data : ''; // Handle null values
                    }
                }
            ],
            pageLength: 50, // Change this value to set default page length
            searching: true
        });

        $('.search_btn').on('click', function() {
            table.draw();  // Redraw the DataTable with the new search parameters
        });

        // var tableApi = $('#tbl_data').DataTable();
        // $('#title').on('change', function() {
        //     var category = $(this).val();
        //     if (category == 'All') {
        //         tableApi.column(1).search('').draw();
        //     } else {
        //         tableApi.column(1).search(category).draw();
        //     }
        // });

        // $('#category').on('change', function() {
        //     let type = $(this).val();
        //     if (type == 'All') {
        //         tableApi.column(4).search('').draw();
        //     } else {
        //         tableApi.column(4).search(type).draw();
        //     }
        // });

        // $('#sub_category').on('change', function() {
        //     let type = $(this).val();
        //     if (type == 'All') {
        //         tableApi.column(5).search('').draw();
        //     } else {
        //         tableApi.column(5).search(type).draw();
        //     }
        // });

        // $('#child_category').on('change', function() {
        //     let type = $(this).val();
        //     if (type == 'All') {
        //         tableApi.column(6).search('').draw();
        //     } else {
        //         tableApi.column(6).search(type).draw();
        //     }
        // });

        // $('#template').on('change', function() {
        //     let type = $(this).val();
        //     if (type == 'All') {
        //         tableApi.column(7).search('').draw();
        //     } else {
        //         tableApi.column(7).search(type).draw();
        //     }
        // });

        // $('#search').on('input', function() {
        //     let text = $(this).val();
        //     if (text === '') {
        //         tableApi.search('').draw();
        //     } else {
        //         tableApi.search(text).draw();
        //     }
        // });

        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            $('#edit_form_id_input').val(id);
            $('#edit_form').submit();
        });

        $(document).ready(function() {
        // Existing DataTable and event handlers...

        // Handle Export CSV button click
        $('#export_csv').on('click', function() {
            window.location.href = "{{ route('admin.exportProductsCSV') }}";
        });

        // Existing event handlers...
       });

        $(document).on('click', '.duplicate', function() {
            var id = $(this).data('id');
            $('#edit_form_id_input').val(id);
            $('#duplicate').val('yes');
            $('#edit_form').submit();
        });

        function showtoaster() {
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function() {
                x.className = x.className.replace("show", "");
            }, 2000);
        }

        $(document).on('click', '.delete', function() {
            var id = $(this).data('id');
            var status = $(this).data('status');

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('id', id);
            formData.append('status', status);
            var $rowToDelete = $(this).closest('tr');

            $.ajax({
                url: "{{ route('admin.updateStatus') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        $rowToDelete.fadeOut('slow', function() {
                            $(this).remove();
                        });
                        showtoaster();
                    } else if (response.status === 'error') {
                        alert('Contact To Developer');
                    }
                },
                error: function(error) {
                    alert('Contact To Developer');
                }
            });
        });
    });
</script>
@endPushOnce
