@extends('admin.layouts.default')
@section('title', 'Order_Consutations')
@section('content')
<!-- main stated -->
<main id="main" class="main">

    <style>
        .read-more-btn {
            color: #0d6efd !important;
            font-weight: 600;
            padding: 0 !important;
            margin: 0 !important;
            background-color: #ffff !important;
        }

        .read-less-btn {
            color: #dc3545 !important;
            font-weight: 600;
            padding: 0 !important;
            margin: 0 !important;
            background-color: #ffff !important;

        }

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
    </style>

    <div class="pagetitle">
        <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | Order Consultations</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Order Consultations </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header mt-3" id="tbl_buttons" style="border: 0 !important; border-color: transparent !important;">
                    </div>
                    @if($user_profile_details)
                    <div class="row px-4 mt-2 mb-3">
                        <div class="col-12">
                            <h4 class="fw-bold ">Customer Profile Details:</h4>
                            <label for="" class="fw-bold px-2 ">Name: </label> <span> {{$user_profile_details->name ?? '' }}</span><br>
                            <label for="" class="fw-bold px-2">Phone: </label> <span> {{$user_profile_details->profile->phone ?? '' }}</span><br>
                            <label for="" class="fw-bold px-2">Gender: </label> <span> {{$user_profile_details->profile->gender ?? '' }}</span><br>
                            <label for="" class="fw-bold px-2">DOB: </label> <span> {{$user_profile_details->profile->date_of_birth ?? '' }}</span><br>
                            <label for="" class="fw-bold px-2">Address: </label> <span> {{$user_profile_details->address->address ?? '' }}</span><br>
                            <label for="" class="fw-bold px-2">Postal Code: </label> <span> {{$user_profile_details->address->zip_code ?? '' }}</span><br>
                            <label for="" class="fw-bold px-2">Identity Document: </label>
                            <span>
                                @if($user_profile_details->id_document)
                                <a class="fw-bold btn-link mx-2" href="{{ asset('storage/'.$user_profile_details->id_document) }}" target="_blank">
                                    <i class="bi bi-eye-fill"></i> View File
                                </a>
                                <a class="fw-bold btn-link mx-2" href="{{ asset('storage/'.$user_profile_details->id_document) }}" download>
                                    <i class="bi bi-cloud-download"></i> Download File
                                </a>
                                @endif
                            </span><br>

                        </div>
                    </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <table id="tbl_data" class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="vertical-align: middle; text-align: center;">Question_id</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> </td>
                                    <td class=" fw-bold text-center" style="vertical-align: middle; text-align: center; background-color:aquamarine !important; "> Generic Constulation </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                                @foreach($generic_consultation as $key => $val)
                                <tr>
                                    <td style="vertical-align: middle; text-align: center;">#{{$val['id']}}</td>
                                    <td>
                                        @if($val['title'])
                                        @if(strlen(strip_tags($val['title'])) > 80)
                                        <span class="description-preview">{!! Str::limit(strip_tags($val['title'] ?? ''), 80) !!}</span>
                                        <span class="description-full" style="display: none;">{!! $val['title'] ?? '' !!}</span>
                                        <button class="btn btn-link read-more-btn">Read More</button>
                                        @else
                                        <span class="description-full">{!! $val['title'] ?? '' !!}</span>
                                        @endif
                                        @else
                                        <span class="text-center"></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($val['desc'])
                                        @if(strlen(strip_tags($val['desc'])) > 80)
                                        <span class="description-preview">{!! Str::limit(strip_tags($val['desc'] ?? ''), 80) !!}</span>
                                        <span class="description-full" style="display: none;">{!! $val['desc'] ?? '' !!}</span>
                                        <button class="btn btn-link read-more-btn">Read More</button>
                                        @else
                                        <span class="description-full">{!! $val['desc'] ?? '' !!}</span>
                                        @endif
                                        @else
                                        <span class="text-center"></span>
                                        @endif

                                    </td>
                                    <td>
                                        @if (is_array($val['answer']))
                                        @foreach ($val['answer'] as $key => $value)
                                        <p>{{ ucfirst(trim($key, "'")) }}: {{ $value }}</p>
                                        @endforeach
                                        @elseif (Str::startsWith($val['answer'], 'consultation/product/'))
                                        <a class="fw-bold btn-link mx-2" href="{{ asset('storage/'.$val['answer']) }}" target="_blank">
                                            <i class="bi bi-eye-fill"></i> View File
                                        </a>
                                        <a class="fw-bold btn-link mx-2" href="{{ asset('storage/'.$val['answer']) }}" download>
                                            <i class="bi bi-cloud-download"></i> Download File
                                        </a>
                                        @else
                                        <p>{{ $val['answer'] }}</p>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                                @if($product_consultation)
                                <tr>
                                    <td> </td>
                                    <td class=" fw-bold text-center" style="vertical-align: middle; text-align: center; background-color:aquamarine !important; "> Product Constulation </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                                @foreach($product_consultation ?? [] as $ind => $value)
                                <tr>
                                    <td style="vertical-align: middle; text-align: center;">#{{$value['id']}}</td>
                                    <td>{{$value['title']}}</td>
                                    <td>
                                        @if($value['desc'])
                                        @if(strlen(strip_tags($value['desc'])) > 80)
                                        <span class="description-preview">{!! Str::limit(strip_tags($value['desc'] ?? ''), 80) !!}</span>
                                        <span class="description-full" style="display: none;">{!! $value['desc'] ?? '' !!}</span>
                                        <button class="btn btn-link read-more-btn">Read More</button>
                                        @else
                                        <span class="description-full">{!! $value['desc'] ?? '' !!}</span>
                                        @endif
                                        @else
                                        <span class="text-center"></span>
                                        @endif

                                    </td>
                                    <td>
                                        @if (Str::startsWith($value['answer'], 'consultation/product/'))
                                        <a class="fw-bold btn-link mx-2" href="{{ asset('storage/'.$value['answer']) }}" target="_blank">
                                            <i class="bi bi-eye-fill"></i> View File
                                        </a>
                                        <a class="fw-bold btn-link mx-2" href="{{ asset('storage/'.$value['answer']) }}" download>
                                            <i class="bi bi-cloud-download"></i> Download File
                                        </a>
                                        @else
                                        <p>{{ $value['answer'] }}</p>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div id="ajax-alert" class="alert" style="display: none;"></div>
                    @if(($user->hasRole('super_admin')) || ($user->hasRole('pharmacy'))) 
                    <div class="col-md-12 d-flex justify-content-start align-items-center mt-3" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        <form id="approval-form" action="{{ route('admin.changeProductStatus') }}" method="POST" style="width: 100%; max-width: 600px;">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                        
                            @php
                                $hasConsultations = false;
                                $productId = null;
                            @endphp
                        
                            @if($product_consultation && count($product_consultation) > 0)
                                @php
                                    $hasConsultations = true;
                                    $productId = $product_consultation[0]['product_id'];
                                @endphp
                            @elseif($generic_consultation && count($generic_consultation) > 0)
                                @php
                                    $hasConsultations = true;
                                    $productId = $generic_consultation[0]['product_id'];
                                @endphp
                            @endif
                        
                            @if($hasConsultations)
                                <input type="hidden" name="approvals[0][product_id]" value="{{ $productId }}">
                                <div class="form-group" style="margin-bottom: 15px;">
                                    <button type="button" name="approvals[0][status]" value="Approved" class="btn btn-success approve-btn" style="margin-right: 10px; background-color:#176d11; padding: 10px 20px; border-radius: 5px; font-weight: bold; font-size: 16px; cursor: pointer;">
                                        Approve
                                    </button>
                                    <button type="button" name="approvals[0][status]" value="Not Approved" class="btn btn-danger reject-btn" style="padding: 10px 20px; background-color: #c91d12; border-radius: 5px; font-weight: bold; font-size: 16px; cursor: pointer;">
                                        Reject
                                    </button>
                                </div>
                            @else
                                <p style="text-align: center; color: #dc3545; font-weight: bold;">No product consultations available for approval.</p>
                            @endif
                        </form>
                        
                    </div>
                    @endif                   
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>
</main>
@stop

@pushOnce('scripts')
<script>
    $(document).ready(function() {
        $('.approve-btn, .reject-btn').click(function() {
            var status = $(this).val();
            var form = $('#approval-form');
            var formData = form.serialize(); // Serialize the form data
            
            // Add the status to the serialized data
            formData += '&approvals[0][status]=' + status;

            $.ajax({
                url: form.attr('action'), // Use the form's action URL
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Show success alert
                    $('#ajax-alert')
                        .removeClass('alert-danger')
                        .addClass('alert-success')
                        .text('Status updated successfully!')
                        .fadeIn()
                        .delay(3000) // Keep it visible for 3 seconds
                        .fadeOut();
                },
                error: function(xhr, status, error) {
                    // Show error alert
                    $('#ajax-alert')
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .text('Error updating status.')
                        .fadeIn()
                        .delay(3000) // Keep it visible for 3 seconds
                        .fadeOut();
                }
            });
        });
        $('.read-more-btn').click(function() {
            var $descriptionPreview = $(this).siblings('.description-preview');
            var $descriptionFull = $(this).siblings('.description-full');

            if ($descriptionPreview.is(':visible')) {
                $descriptionPreview.hide();
                $descriptionFull.show();
                $(this).removeClass('btn-primary').addClass('read-less-btn').text('Read Less');
            } else {
                $descriptionPreview.show();
                $descriptionFull.hide();
                $(this).removeClass('read-less-btn').addClass('btn-primary').text('Read More');
            }
        });
    });

    $(function() {
        $("#tbl_data").DataTable({
            "paging": false,
            "responsive": false,
            "lengthChange": false,
            "autoWidth": true,
            "searching": true,
            "ordering": false,
            "info": false,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            "buttons": [{
                    extend: 'pdf',
                    text: 'Download PDF ',
                    className: 'btn-blue',
                },
                // {
                //     extend: 'excel',
                //     text: 'Donwload Excel ',
                //     className: 'btn-blue', 
                // },

                {
                    extend: 'print',
                    text: 'Print Out',
                    className: 'btn-blue',
                }
            ]
        }).buttons().container().appendTo('#tbl_buttons');
    });
</script>
@endPushOnce