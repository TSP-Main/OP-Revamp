@extends('admin.layouts.default')
@section('title', 'Order Detail')
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


            .date {
                font-size: 11px
            }

            .comment-text {
                font-size: 12px
            }

            .fs-12 {
                font-size: 12px
            }

            .shadow-none {
                box-shadow: none
            }

            .name {
                color: #007bff
            }

            .cursor:hover {
                color: blue
            }

            .cursor {
                cursor: pointer
            }

            .textarea {
                resize: none
            }
        </style>

        <div class="pagetitle ">
            <div class="">
                <form id="create_pdf_from" action="{{route('pdf.creator')}}" method="post">
                    <input type="hidden" name="content" value="{{json_encode($order)}}" required>
                    <input type="hidden" name="view_name" value="order_details" required>
                    <input type="hidden" name="role" value="{{ $user->role ?? ''}}" required>
                </form>
                <h1 class="w-100">
                    <a href="javascript:void(0);" onclick="window.history.back();"
                       class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> |
                    Order Detail
                    <button type="submit" form="create_pdf_from"
                            class=" btn fs-5 py-1  {{($order['print'] == 'Printed') ? 'btn-success bg-success ' : 'btn-primary bg-primary' }} fw-semibold"
                            style="float:right;">{{$order['print'] ?? '' }}</button>
                    @if((isset($user->role) && $user->role == user_roles('1')))
                        <button type="button" data-bs-toggle="modal" data-bs-target="#order_refund_mdl"
                                class=" btn fs-5 py-1  mx-2 btn-danger  bg-danger fw-semibold" style="float:right;"><i
                                class="bi-arrow-counterclockwise"></i>Refund
                        </button>
                    @endif
                </h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">Pages</li>
                        <li class="breadcrumb-item active">Order Detail</li>
                    </ol>
                </nav>
            </div>
            <div class="">

    <div class="pagetitle ">
        <div class="">
            <form id="create_pdf_from" action="{{route('pdf.creator')}}" method="post">
                <input type="hidden" name="content" value="{{json_encode($order)}}" required>
                <input type="hidden" name="view_name" value="order_details" required>
                <input type="hidden" name="role" value="{{ $user->role ?? ''}}" required>
            </form>
            <h1 class="w-100">
                <a href="javascript:void(0);" onclick="window.history.back();"
                    class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> |
                Order Detail
                <button type="submit" form="create_pdf_from"
                    class=" btn fs-5 py-1  {{($order['print'] == 'Printed') ? 'btn-success bg-success ' : 'btn-primary bg-primary' }} fw-semibold"
                    style="float:right;">{{$order['print'] ?? '' }}</button>
                @if((isset($user->role) && $user->role == user_roles('1')))
                    <button type="button" data-bs-toggle="modal" data-bs-target="#order_refund_mdl"
                        class=" btn fs-5 py-1  mx-2 btn-danger  bg-danger fw-semibold" style="float:right;"> <i
                            class="bi-arrow-counterclockwise"></i>Refund</button>
                @endif

        </div>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">

            <!-- Display Success Message -->
            @if(session('status') == 'fail')
                <div class="alert alert-danger">
                    <strong>Error:</strong> {{ session('msg') }}
                </div>
            @endif

            @if(session('status') == 'success')
                <div class="alert alert-success">
                    <strong>Success:</strong> {{ session('msg') }}
                </div>
            @endif
            <div class="col-md-4">
                <div class="card  d-flex flex-column">
                    <div class="card-header mt-2" style="border: 0 !important; border-color: transparent !important;">
                    </div>
                    <div class="card-body flex-grow-1">
                        <div class="text">
                            <h4 class="fw-bold">Customer Details</h4>
                            <span><b>Name:
                                </b>{{ ($order['shipping_details']['firstName']) ? $order['shipping_details']['firstName'] . ' ' . $order['shipping_details']['lastName'] : $order['user']['name'] }}</span><br>
                            <span><b>Order Id: </b><span class="text-primary">#{{$order['id']}}</span></span>
                        </div>
                        <div class="text">
                            <p class="pr-2">
                                <span><b>Phone #:</b>
                                    {{$order['shipping_details']['phone'] ?? $order['user']['phone'] }}</span>
                            </p>
                            <a href="mailTo:{{$order['shipping_details']['email'] ?? $order['user']['email']}}">
                                <p class="fw-bold m-0">Send Mail: </p>
                                <p class="mt-0 text-dark">
                                    <b class="">Email:
                                    </b>{{$order['shipping_details']['email'] ?? $order['user']['email']}}
                                </p>
                                <a href="mailTo:{{$order['shipping_details']['email'] ?? $order['user']['email']}}">
                                    <p class="fw-bold m-0">Send Mail: </p>
                                    <p class="mt-0 text-dark">
                                        <b class="">Email: </b>{{$order['shipping_details']['email'] ?? $order['user']['email']}}
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="col-md-4">
                <div class="card  d-flex flex-column">
                    <div class="card-header mt-2" style="border: 0 !important; border-color: transparent !important;">
                    </div>
                    <div class="card-body flex-grow-1">
                        <form class="needs-validation" id="shipping_address_form" method="post"
                            action="{{ route('admin.updateShippingAddress') }}" novalidate>
                            @csrf
                            <input type="hidden" name="order_id" value="{{  $order['id'] ?? '' }}">
                            <div class="col-12">
                                <label class="form-label"><b>City:</b>
                                    {{$order['shipping_details']['city'] ?? $order['user']['city'] }}</label>
                                <input class="form-control me-2" type="text" name="city" id="city"
                                    value="{{$order['shipping_details']['city'] ?? $order['user']['city'] }}"
                                    placeholder="Change City">
                            </div>
                            <div class="col-12">
                                <label class="form-label"><b>Postal Code:</b>
                                    {{$order['shipping_details']['zip_code'] ?? $order['user']['zip_code'] }}</label>
                                <input class="form-control me-2" type="text" name="postal_code" id="postal_code"
                                    value=" {{$order['shipping_details']['zip_code'] ?? $order['user']['zip_code'] }}"
                                    placeholder="Change Postal Code">
                            </div>
                            <div class="col-12">
                                <label class="form-label"><b>Address 1:</b>
                                    {{$order['shipping_details']['address'] ?? $order['user']['address'] }}</label>
                                <input class="form-control me-2" type="text" name="address1" id="address1"
                                    value="{{$order['shipping_details']['address'] ?? $order['user']['address'] }}"
                                    placeholder="Change Address 1">
                            </div>
                            <div class="col-12">
                                <label class="form-label"><b>Address 2:</b>
                                    {{(isset($order['shipping_details']['address2'])) ? $order['shipping_details']['address2'] : ($order['user']['apartment'] ?? '') }}</label>
                                <input class="form-control me-2" type="text" name="address2" id="address2"
                                    value="{{(isset($order['shipping_details']['address2'])) ? $order['shipping_details']['address2'] : ($order['user']['apartment'] ?? '') }}"
                                    placeholder="Change Address 2">
                            </div>
                            <div class=" mt-4 text-end px-4 d-flex d-md-block">
                                <button class="btn btn-primary bg-primary">Update</button>
                            </div>
                        </form>
                        <div class="text mt-2">
                            <h5 class="fw-bold mb-0 ">Billing Address</h5>
                            <span>Same as shipping address</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="card  d-flex flex-column my-auto">
                    <div class="card-header mt-3" style="border: 0 !important; border-color: transparent !important;">
                    </div>
                    <div class="card-body flex-grow-1">
                        <div class="text">
                            <h4 class="fw-bold">Customer Additional Note</h4>
                        </div>
                        <div class="text">
                            <span>{{$order['note'] ?? 'No notes from customer'}}</span><br>
                        </div>
                        <form class="needs-validation" id="additional_note_form" method="post"
                            action="{{ route('admin.updateAdditionalNote') }}" novalidate>
                            @csrf
                            <input type="hidden" name="order_id" value="{{  $order['id'] ?? '' }}">
                            <div class="col-12">
                                <input class="form-control me-2" type="text" name="note" id="note"
                                    value="{{$order['note'] ?? 'No notes from customer'}}" placeholder="Change Note"
                                    required>
                                <div class="invalid-feedback">Please write additional note!</div>
                                @error('note')
                                    <div class="alert-danger text-danger ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class=" mt-4 text-end px-4 d-flex d-md-block">
                                <button class="btn btn-primary bg-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- status -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header mt-3" id="tbl_buttons"
                        style="border: 0 !important; border-color: transparent !important;">
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-lg-12">
                                <div class="text">
                                    <h4 class="fw-bold">Order Placed</h4>
                                    <p>{{ \Carbon\Carbon::parse($order['created_at'])->format('M, d, Y - H:i') }}</p>
                                </div>
                                <div class="card shadow-0 border mb-4">
                                    <div class="card-body">
                                        @foreach($order['orderdetails'] as $key => $val)
                                                                                <div class="row">
                                                                                    @php
                                                                                        $src = (isset($val['variant'])) ? $val['variant']['image'] : $val['product']['main_image'];
                                                                                    @endphp
                                                                                    <div class="col-md-1" style="height:150px; width:150px;">
                                                                                        <img class="img-fluid pt-3 h-100 w-100" id="product_img"
                                                                                            src="{{ asset('storage/' . $src) }}" loading="lazy"
                                                                                            alt="Prodcut Image">
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-md-2 text-left d-flex justify-content-start align-items-center">
                                                                                        <p class="text-muted mb-0"><b>Title: </b> <br>
                                                                                            {!! $val['product_name'] ?? $val['product']['title'] !!}</p>
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-md-2 text-left d-flex justify-content-start align-items-center">
                                                                                        <p class="text-muted mb-0 small"><b>Variant: </b>
                                                                                            <br>{!! $val['variant_details'] ?? '' !!}</p>
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                                                        <p class="text-muted mb-0 small"><b>Quantity: </b>
                                                                                            {{$val['product_qty']}}</p>
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                                                        <p class="text-muted mb-0 small"><b>SKU: </b>
                                                                                            {{$val['variant']['SKU'] ?? $val['product']['SKU']}}</p>
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                                                        @if((isset($user->role) && $user->role == user_roles('1') || $user->role == user_roles('2')))
                                                                                            <p class="text-muted mb-0 small"><b>Price:
                                                                                                </b>£{{number_format((float) str_replace(',', '', $val['product_price'] ?? $val['product']['price']), 2)}}
                                                                                            </p>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                                <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                                                                                @if($val['consultation_type'] == 'premd' || $val['consultation_type'] == 'pmd')
                                                                                    <div class="row d-flex ">
                                                                                        <div class="col-lg-12 text-center ">
                                                                                            <a href="{{ route('admin.consultationView', ['odd_id' => base64_encode($val['id'])]) }}"
                                                                                                class="btn btn-link fw-bold large">
                                                                                                Approved / View Consultation
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">

                                                                                @endif
                                        @endforeach

                                        <div class="row">
                                            <div class="col-md-12 gy-1">
                                                <h5 class="fw-bold underline">User Previous Orders History:</h5>
                                                @php
                                                    $totalOrders = count($userOrders);
                                                    $visibleOrders = array_slice($userOrders, 0, 4);
                                                @endphp

                                                <div class="button-container" style="display: flex; flex-wrap: wrap;">
                                                    @forelse($visibleOrders as $index => $val)
                                                        <a href="{{ route('admin.orderDetail', ['id' => base64_encode($val['id'])]) }}"
                                                            class="btn btn-primary bg-primary m-1">
                                                            <b>{{ $index + 1 }}.</b> #{{ $val['id'] }}
                                                        </a>
                                                    @empty
                                                        <p class="px-5">No Previous Orders Of that Customer.</p>
                                                    @endforelse

                                                    @if($totalOrders > 4)
                                                        <button id="seeMoreBtn" class="btn btn-secondary m-1"
                                                            onclick="toggleOrders()">See More</button>
                                                        <div id="moreOrders" style="display: none;">
                                                            @foreach(array_slice($userOrders, 4) as $index => $val)
                                                                <a href="{{ route('admin.orderDetail', ['id' => base64_encode($val['id'])]) }}"
                                                                    class="btn btn-primary bg-primary m-1">
                                                                    <b>{{ $index + 5 }}.</b> #{{ $val['id'] }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>

                                                <div id="seeLessContainer" style="display: none;">
                                                    <button id="seeLessBtn" class="btn btn-secondary m-1"
                                                        onclick="toggleOrders()">See Less</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between pt-2">
                                    <p class="fw-bold mb-0">Order Status: </p>
                                    <p class="mb-0 fw-bold text-success">{{$order['status']}} </p>
                                </div>
                                @if($order['status'] == 'Shipped')
                                    <div class="d-flex justify-content-between pt-2">
                                        <p class="fw-bold mb-0 ">Tracking Number:</p>
                                        @if($order['shipping_details']['tracking_no'])
                                            <a class="fw-bold  mb-0"
                                                href="https://www.royalmail.com/track-your-item#/tracking-results/{{$order['shipping_details']['tracking_no']}}">{{$order['shipping_details']['tracking_no']}}
                                            </a>
                                        @else
                                            <a class=" btn btn-primary bg-primary fw-bold  mb-0"
                                                href="{{route('admin.getShippingOrder', ['id' => $order['id']])}}">Track</a>
                                        @endif
                                    </div>
                                @endif

                                @if($order['status'] != 'Received')
                                    <div class="d-flex justify-content-arround pt-2">
                                        <p class="fw-bold mb-0 ">Approved By: </p>
                                        <p class="ps-2 mb-0">{{$marked_by['name'] ?? '' }} ({{$marked_by['email'] ?? ''}})
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-arround pt-2">
                                        <p class="fw-bold mb-0 ">Approved At: </p>
                                        <p class="ps-2 mb-0">
                                            {{ $order['approved_at'] ? \Carbon\Carbon::parse($order['approved_at'])->format('d-m-Y H:i:s') : '' }}
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-arround pt-2">
                                        <p class="fw-bold mb-0 ">Health Care Professional Remarks:</p>
                                        <p class="ps-2 mb-0">{{$order['hcp_remarks']}} </p>
                                    </div>
                                @endif

                                @if((isset($user->role) && $user->role == user_roles('1') || $user->role == user_roles('2')))
                                    <div class="d-flex justify-content-between pt-2">
                                        <p class="fw-bold mb-0">Subtotal: </p>
                                        <p class="text-muted mb-0">
                                            £{{ number_format(str_replace(',', '', $order['total_ammount']) - str_replace(',', '', $order['shiping_cost']), 2) }}
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between pt-2">
                                        <p class="fw-bold  mb-0">Shipping Charges: </p>
                                        <p class="text-muted mb-0">
                                            £{{ number_format((float) str_replace(',', '', $order['shiping_cost']), 2) }}</p>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-bold  mb-0">Total: </p>
                                        <p class="text-muted mb-0">
                                            £{{ number_format((float) str_replace(',', '', $order['total_ammount']), 2) }}
                                        </p>
                                    </div>
                                    <div class="card-footer border-0 px-4 ">
                                        <h5
                                            class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">
                                            Total
                                            paid: <span
                                                class="h2 mb-0 ms-2">£{{ number_format((float) str_replace(',', '', $order['total_ammount']), 2) }}</span>
                                        </h5>
                                    </div>
                                @endif
                                @if($order['status'] != 'Shipped' && $order['status'] != 'Not_Approved')
                                    <form id="form_shiping_now" action="{{route('admin.createShippingOrder')}}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="id" required value="{{$order['id']}}">
                                    </form>
                                    <div class="card  mt-1">
                                        <div class="card-body d-flex justify-content-center align-items-center py-3">
                                            <button form="form_shiping_now" type="submit"
                                                class="btn btn-primary bg-primary rounded-pill px-5 py-2 fw-bold">
                                                <i class="bi bi-arrow-right-circle"></i> Ship Now
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <form class="row px-2  needs-validation" action="{{ route('admin.commentStore') }}"
                                  id="commentform" method="POST" novalidate>
                                @csrf
                                <input type="hidden" id="comment_for_id" name="comment_for_id" value="{{$order['id']}}">
                                <input type="hidden" id="comment_for" name="comment_for" value="Orders">
                                <div class="form-group px-3 mb-2">
                                    <textarea class="form-control tinymce-editor" rows="4" id="comment" name="comment"
                                              placeholder="Type your message" required></textarea>
                                </div>
                                <div class="form-group  mb-4 d-flex flex-row justify-content-end px-3">
                                    <button type="submit" id="btn_comment" class="btn btn-primary bg-primary fw-bold">
                                        <div class="spinner-border spinner-border-sm text-white d-none"
                                             id="spinner_coment"></div>
                                        <span id="coment_btn">Add Comment </span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <form class="row px-2  needs-validation" action="{{ route('admin.commentStore') }}"
                            id="commentform" method="POST" novalidate>
                            @csrf
                            <input type="hidden" id="comment_for_id" name="comment_for_id" value="{{$order['id']}}">
                            <input type="hidden" id="comment_for" name="comment_for" value="Orders">
                            <div class="form-group px-3 mb-2">
                                <textarea class="form-control tinymce-editor" rows="4" id="comment" name="comment"
                                    placeholder="Type your message" required></textarea>
                            </div>
                            <div class="form-group  mb-4 d-flex flex-row justify-content-end px-3">
                                <button type="submit" id="btn_comment" class="btn btn-primary bg-primary fw-bold">
                                    <div class="spinner-border spinner-border-sm text-white d-none" id="spinner_coment">
                                    </div>
                                    <span id="coment_btn">Add Comment </span>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </section>
        <input type="hidden" id="user_id" value="{{auth()->user()->id}}">
    </main>
    <!-- End #main -->

<div class="modal fade" id="order_refund_mdl" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #20B2AA;">
                <h5 class="modal-title fw-bold text-white">Order Ammount Refund</h5>
                <button type="button" class="btn-close fw-bold text-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_refund" class="row g-3 mt-1 needs-validation" novalidate
                    action="{{route('admin.refundOrder')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" required value="{{$order['id']}}">
                    <input type="hidden" id="status" name="status" class="form-control" value="Refund" required>

                    <div class="col-12">
                        <label for="ammount" class="form-label fw-bold">Ammount To Refund: </label>
                        <input type="text" name="ammount" class="form-control" id="ammount"
                            value="{{$order['total_ammount']}}" required>
                        <div class="invalid-feedback">Please enter ammount!</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary bg-secondary" data-bs-dismiss="modal">Close</button>
                <button form="form_refund" type="submit" class="btn text-white fw-bold"
                    style="background: #20B2AA;">Save changes</button>
            </div>
        </div>
    </div>
@stop

@pushOnce('scripts')
    <script>
        $(function () {
            $("#tbl_data").DataTable({
                "paging": true,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "pageLength": 50,
                "pageLength": 50,
                "buttons": [{
                    extend: 'pdf',
                    text: 'Download PDF ',
                    className: 'btn-blue',
                },
                {
                    extend: 'print',
                    text: 'Print Out',
                    className: 'btn-blue',
                }
                ]
            }).buttons().container().appendTo('#tbl_buttons');
        });

        $(document).ready(function () {
            setInterval(comments, 10000);
            comments();
            // get comments  data in through the api...
            function comments() {
                var apiurl = @json(route('admin.comments', ['id' => $order['id']]));
                var user_id = parseInt($('#user_id').val());
                $.ajax({
                    url: apiurl,
                    type: 'GET',
                    beforeSend: function () {

                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            var comment_html = '';

                            if (response.data && response.data.length > 0) {
                                $('.no_comment').addClass('d-none');
                                response.data.forEach(function (data) {
                                    let createdDate = new Date(data.created_at);
                                    let formattedDate = createdDate.toLocaleString();
                                    formattedDate = formattedDate.replace(/\//g, '-');
                                    let user_pic = data.user_pic ?? '/assets/admin/img/profile-img1.png';
                                    let comment_data = '';
                                    if (user_id == data.user_id) {
                                        comment_data = `<div class="d-flex flex-row p-3">
                                        <img class="img-fuild " src="${user_pic}" width="45" height="45" style="border-radius:50% !important">
                                        <div class=" chat ml-2 p-3"><span class="text-muted">${data.comment}</span></div>
                                        </div>`;
                                    } else {
                                        comment_data = `<div class="d-flex flex-row p-3">
                                        <div class=" bg-white mr-2 p-3"><span class="text-muted">${data.comment}</span></div>
                                        <img class="img-fuild " src="${user_pic}" width="45" height="45" style="border-radius:50% !important">
                                        </div>`;
                                    }
                                    comment_html += comment_data;
                                });
                            } else {
                                $('.no_comment').removeClass('d-none');
                            }

                            $('.comment_data').html(comment_html);
                        } else {
                            // alert('contact to developer');
                            console.log(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        // alert('contact to developer');
                        console.log(status);
                        // showAlert("Error", 'Request Can not Proceed', 'Cannot proceed further');
                    }
                });
            }
            // Adding  comment in through the api...
            $('#commentform').on('submit', function (e) {
                e.preventDefault();
                var apiname = $(this).attr('action');
                var apiurl = apiname;
                var formData = new FormData(this);
                var comment = formData.get('comment');
                var user_pic = "{{ ($user->user_pic ?? '') ? asset('storage/' . $user->user_pic) : asset('assets/admin/img/profile-img1.png') }}";
                if (comment) {
                    $.ajax({
                        url: apiurl,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            $('#spinner_coment').removeClass('d-none');
                            $('#coment_btn').addClass('d-none');
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                $('.no_comment').addClass('d-none');
                                comments();
                                $('#comment').val('');
                                $('#spinner_coment').addClass('d-none');
                                $('#coment_btn').removeClass('d-none').prop('disabled', false);
                            } else if (response.status === 'error') {
                                // alert('contact to developer');
                                console.log(response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            // alert('contact to developer');
                            console.log(status);
                            $('#spinner_coment').addClass('d-none');
                            $('#coment_btn').removeClass('d-none').prop('disabled', false);
                        }
                    });
                }
            });


        });
    </script>
    <script>
        function toggleOrders() {
            const moreOrders = document.getElementById('moreOrders');
            const seeMoreBtn = document.getElementById('seeMoreBtn');
            const seeLessContainer = document.getElementById('seeLessContainer');

            if (moreOrders.style.display === 'none') {
                moreOrders.style.display = 'flex'; // or 'block', depending on your layout
                seeMoreBtn.style.display = 'none';
                seeLessContainer.style.display = 'block';
            } else {
                moreOrders.style.display = 'none';
                seeMoreBtn.style.display = 'block';
                seeLessContainer.style.display = 'none';
            }
        }
    </script>
@endPushOnce
