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
{{--                        @dd($user_profile_details->address->address)--}}
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
                        @if((isset($user->role) && $user->role != user_roles('4' , '2')) && ($order->status == 'Received' || $order->status == 'Not_Approved' || $order->status == 'Approved'))
                        <div class="card mt-4">
                            <div class="card-body d-flex justify-content-center align-items-center py-3">
                                <button class="btn btn-success rounded-pill px-5 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#doctor_remarks">
                                    <i class="bi bi-arrow-right-circle"></i> Proceed Next
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>

</main>
<!-- End #main -->
<!-- modal for doctors approval -->
@if((isset($user->role) && $user->role != user_roles('4')))
<div class="modal fade" id="doctor_remarks" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #20B2AA;">
                <h5 class="modal-title fw-bold text-white">HealthCare Professional Feedback</h5>
                <button type="button" class="btn-close fw-bold text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_hcp_remarks" class="row g-3 mt-1 needs-validation" novalidate action="{{route('admin.changeStatus')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" required value="{{$order_user_detail->order_id}}">
                    <input type="hidden" name="approved_by" required value="{{$user->id}}">
                    <div class="col-12">
                        <label for="status" class="form-label fw-bold">Order Status :</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="" selected>Choose...</option>
                            <option value="Approved">Approved</option>
                            <option value="Not_Approved">Not Approved</option>
                        </select>
                        <div class="invalid-feedback">Please select status!</div>
                    </div>

                    <div class="col-12">
                        <label for="hcp_remarks" class="form-label fw-bold">Health Care Professional Notes: </label>
                        <textarea name="hcp_remarks" class="form-control" id="hcp_remarks" rows="4" placeholder="write here..." required></textarea>
                        <div class="invalid-feedback">Please write Notes!</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary bg-secondary" data-bs-dismiss="modal">Close</button>
                <button form="form_hcp_remarks" type="submit" class="btn text-white fw-bold" style="background: #20B2AA;">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endif
@stop

@pushOnce('scripts')
<script>
    $(document).ready(function() {
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
