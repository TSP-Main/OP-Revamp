@extends('admin.layouts.default')
@section('title', 'Products Limits')
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

        /* Custom checkbox styles */
        .custom-checkbox {
            position: relative;
            display: inline-block;
            width: 26px;
            height: 29px;
            background-color: #fff;
            border: 2px solid #6c757d;
            border-radius: 5px;
            cursor: pointer;
        }

        .custom-checkbox::after {
            background-color: #03c4a5 !important;
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 12px;
            height: 12px;
            border-bottom: 2px solid #000;
            /* Changed border color to black */
            border-right: 2px solid #000;
            /* Changed border color to black */
            transform-origin: bottom right;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        /* Checkbox checked state */
        .custom-checkbox input:checked+.custom-checkbox::after {
            opacity: 1;
        }

        /* Change background color to green when checked */
        .custom-checkbox input:checked+.custom-checkbox {
            background-color: #03c4a5 !important;
            /* Green background color */
        }

        /* Hide the default checkbox */
        .custom-checkbox input[type="checkbox"] {
            opacity: 0;
            width: 0;
            height: 0;
            background-color: #03c4a5 !important;
        }

        .form-control-sm {
            min-height: calc(1.5em + .5rem + calc(var(--bs-border-width)* 2)) !important;
            padding: .5rem 1rem !important;
            font-size: 1rem !important;
            border-radius: var(--bs-border-radius-sm) !important;
            margin: 1rem 5px !important;
            width: 100% !important;
        }

        .dataTables_filter {
            text-align: center !important;
            font-weight: bolder !important;
            font-size: larger !important;
        }

        #snackbar {
            visibility: hidden;
            /* Hidden by default. Visible on click */
            min-width: 250px;
            /* Set a default minimum width */
            margin-left: -125px;
            /* Divide value of min-width by 2 */
            background-color: #03c4a5;
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
                <li class="breadcrumb-item active">Products Limits</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header mt-3" id="tbl_buttons" style="border: 0 !important; border-color: transparent !important;">
                    </div>
                    <div class="card-body">
                        <table id="tbl_data" class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Details</th>
                                    <th>Min Quantity <span class="extra-text">(Buy limit)</span></th>
                                    <th>Max Quantity <span class="extra-text">(Buy limit)</span></th>
                                    <th>Comibine Variants</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $key => $value)
                                <tr>
                                    <th style="vertical-align: middle; text-align: center;">{{ ++$key ?? ''}}</th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/'.$value['main_image'])}}" class="rounded-circle" alt="no image" style="width: 45px; height: 45px" />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">{{ $value['title'] ?? ''}}</p>
                                            </div>
                                        </div>

                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <input type="text" id="min_buy_{{$value['id']}}" name="min_buy[{{$value['id']}}]" value="{{$value['min_buy'] ?? ''}}">
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <input type="text" id="max_buy_{{$value['id']}}" name="max_buy[{{$value['id']}}]" value="{{$value['max_buy'] ?? ''}}">
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <input type="checkbox" {{($value['comb_variants'] == 'yes') ? 'checked' : '' }} class="custom-checkbox" id="comb_variants_{{$value['id']}}" name="comb_variants[{{$value['id']}}]">
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <a class="btn btn-primary update" style="cursor: pointer;" title="Edit" data-id="{{$value['id']}}" data-toggle="tooltip">
                                            <i class="bi bi-arrow-clockwise"></i> Update
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>
    <div id="snackbar" class="fw-bold">Limit updated Successfully.</div>
</main>


@stop

@pushOnce('scripts')
<script>
    $(function() {
        $("#tbl_data").DataTable({
            "paging": true,
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": true,
            "ordering": true,
            "info": true,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tbl_buttons');
    });

    function showtoaster() {
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function() {
            x.className = x.className.replace("show", "");
        }, 2000);
    }
    $(document).ready(function() {
        $(document).on('click','.update',function() {
            var id = $(this).data('id');
            let min_buy = $('#min_buy_' + id).val();
            let max_buy = $('#max_buy_' + id).val();
            let comb_variants = $('#comb_variants_' + id).prop('checked') ? 'yes' : 'no';
            // Get CSRF token from meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            var formData = new FormData();
            formData.append('_token', csrfToken); // Append CSRF token
            formData.append('id', id);
            formData.append('min_buy', min_buy);
            formData.append('max_buy', max_buy);
            formData.append('comb_variants', comb_variants);

            $.ajax({
                url: "{{route('admin.updateBuyLimits')}}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
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