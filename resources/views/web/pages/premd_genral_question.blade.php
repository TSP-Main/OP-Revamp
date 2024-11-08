@extends('web.layouts.default')
@section('title', 'Product Questions')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<style>
    .styled-radio {
        cursor: pointer;
        width: 20px;
        height: 20px;
        margin-right: 10px;
        border: 2px solid #0dcaf0;
        border-radius: 50%;
        outline: none;
    }

    .styled-radio:hover {
        outline: auto;
    }

    .styled-radio:checked {
        background-color: #0dcaf0;
        border: 2px solid #0dcaf0;
        box-shadow: none;
        outline: none;
    }


    .btn-radio {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem;
        padding: 6px 20px !important;
        cursor: pointer;
        outline: none;
        background-color: #ced4da;
        font-weight: 400;
    }

    .btn-radio:checked {
        background-color: #0dcaf0 !important;
        border: 2px solid #0dcaf0;
        color: #fff;
    }

    .btn-radio:focus {
        box-shadow: none;
    }

    .btn-radio:hover {
        background-color: #d8e5e8;
    }

    .btn-radio::before {
        content: attr(data-label);
    }

    /* Hide the actual radio input */
    .btn-radio input[type="radio"] {
        display: none;
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

    .bnt-checkout:hover {
        background-color: #03c4a5;
        border-radius: 10px !important;
    }

    .bnt-checkout {
        border-radius: 10px !important;
    }

    .form-group {
        background-color: #15d3ea2e;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="firstconsultationstart">
                <div class="text">
                    <h2>General Health Questions</h2>
                    <p class="mb-3">The information you provide us is treated with the utmost confidentiality and will be reviewed by a GPhC registered independent prescriber. The questions listed are to provide the prescriber with an appropriate level of information to make an informed decision on whether the treatment is suitable or not.</p>
                </div>
                <form id="premed_generic_question" action="{{route('web.consultationStore')}}" method="post">
                    @csrf
                    <input type="hidden" name="template" required value="{{$template}}">
                    <input type="hidden" name="product_id" required value="{{$product_id}}">

                    <div class="form-group px-4 pt-3 pb-2">
                        <div class="d-flex question align-items-start">
                            <p class="me-auto mb-2 pt-1" style="font-weight: 400;">{{$questions[0]['title'] ?? '' }}</p>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_{{$questions[0]['id']}}" class="btn-radio option" value="Yes" data-append_id="apped_quest_{{$questions[0]['id']}}" data-selector="question_{{$questions[2]['id']}}" data-label="Yes" required>
                            </label>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_{{$questions[0]['id']}}" class="btn-radio option" value="No" data-append_id="apped_quest_{{$questions[0]['id']}}" data-selector="question_{{$questions[1]['id']}}" data-label="No" required>
                            </label>
                        </div>
                        <div id="apped_quest_{{$questions[0]['id']}}">

                        </div>
                    </div>

                    <div class="form-group px-4 pt-3 pb-2">
                        <div class="d-flex question align-items-start">
                            <p class="me-auto mb-2 pt-1" style="font-weight: 400;">{{$questions[4]['title'] ?? '' }}</p>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_{{$questions[4]['id']}}" class="btn-radio option" value="Yes" data-append_id="apped_quest_{{$questions[4]['id']}}" data-selector="nothing" data-label="Yes" required>
                            </label>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_{{$questions[4]['id']}}" class="btn-radio option" value="No" data-append_id="apped_quest_{{$questions[4]['id']}}" data-selector="alert_1" data-label="No" required>
                            </label>
                        </div>
                        <div id="apped_quest_{{$questions[4]['id']}}">

                        </div>
                    </div>

                    <div class="form-group px-4 pt-3 pb-2">
                        <div class="d-flex question align-items-start">
                            <p class="me-auto mb-2 pt-1" style="font-weight: 400;">{{$questions[5]['title'] ?? '' }}</p>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_{{$questions[5]['id']}}" class="btn-radio option" value="Yes" data-append_id="apped_quest_{{$questions[5]['id']}}" data-selector="question_{{$questions[6]['id']}}" data-label="Yes" required>
                            </label>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_{{$questions[5]['id']}}" class="btn-radio option" value="No" data-append_id="apped_quest_{{$questions[5]['id']}}" data-selector="nothing" data-label="No" required>
                            </label>
                        </div>
                        <div id="apped_quest_{{$questions[5]['id']}}">

                        </div>
                    </div>

                    <div class="form-group px-4 pt-3 pb-2">
                        <div class="d-flex question align-items-start">
                            <p class="me-auto mb-2 pt-1" style="font-weight: 400;">{{$questions[7]['title'] ?? '' }}</p>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_{{$questions[7]['id']}}" class="btn-radio option" value="Yes" data-append_id="apped_quest_{{$questions[7]['id']}}" data-selector="question_{{$questions[8]['id']}}" data-label="Yes" required>
                            </label>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_{{$questions[7]['id']}}" class="btn-radio option" value="No" data-append_id="apped_quest_{{$questions[7]['id']}}" data-selector="nothing" data-label="No" required>
                            </label>
                        </div>
                        <div id="apped_quest_{{$questions[7]['id']}}">

                        </div>
                    </div>

                    <div class="form-group px-4 pt-3 pb-2">
                        <div class="d-flex question align-items-start">
                            <p class="me-auto mb-2 pt-1" style="font-weight: 400;">{{$questions[9]['title'] ?? '' }}</p>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_{{$questions[9]['id']}}" class="btn-radio option" value="Yes" data-append_id="apped_quest_{{$questions[9]['id']}}" data-selector="question_{{$questions[10]['id']}}" data-label="Yes" required>
                            </label>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_{{$questions[9]['id']}}" class="btn-radio option" value="No" data-append_id="apped_quest_{{$questions[9]['id']}}" data-selector="nothing" data-label="No" required>
                            </label>
                        </div>
                        <div id="apped_quest_{{$questions[9]['id']}}">

                        </div>
                    </div>

                    <div class="form-group px-4 pt-3 pb-2">
                        <div class="d-flex question align-items-start">
                            <p class="me-auto mb-2 pt-1" style="font-weight: 400;">{{$questions[11]['title'] ?? '' }}</p>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_{{$questions[11]['id']}}" class="btn-radio option" value="Yes" data-append_id="apped_quest_{{$questions[11]['id']}}" data-selector="question_{{$questions[12]['id']}}" data-label="Yes" required>
                            </label>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_{{$questions[11]['id']}}" class="btn-radio option" value="No" data-append_id="apped_quest_{{$questions[11]['id']}}" data-selector="nothing" data-label="No" required>
                            </label>
                        </div>
                        <div id="apped_quest_{{$questions[11]['id']}}">

                        </div>
                    </div>

                    <div class="form-group px-4 pt-3 pb-2">
                        <div class="d-flex question align-items-start">
                            <p class="me-auto mb-2 pt-1" style="font-weight: 400;">{{$questions[13]['title'] ?? '' }}</p>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_{{$questions[13]['id']}}" class="btn-radio option" value="Yes" data-append_id="apped_quest_{{$questions[13]['id']}}" data-selector="question_{{$questions[14]['id']}}" data-label="Yes" required>
                            </label>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_{{$questions[13]['id']}}" class="btn-radio option" value="No" data-append_id="apped_quest_{{$questions[13]['id']}}" data-selector="nothing" data-label="No" required>
                            </label>
                        </div>
                        <div id="apped_quest_{{$questions[13]['id']}}">

                        </div>
                    </div>

                    <div class="form-group px-4 pt-4 pb-2">
                        <div class="question ">
                            <p class="me-auto">What is your height?</p>

                            <div class="mt-2 mb-4">
                                <div class="col-9" style="cursor:pointer;">
                                    <p id="height_switch" class="text-end btn-link fw-bold">Switch to cm</p>
                                </div>
                                <div class="d-flex inch d-flex justify-content-end ">
                                    <div class="col-4">
                                        <label for="feet" class="form-lable ">Feet</lable>
                                            <input type="number" min="0.00" class="form-control w-100 " style="padding: 11px !important; " id="feet" name="quest_16['feet']" placeholder="0.0">
                                    </div>
                                    <div class="col-4">
                                        <label for="inches" class="form-lable ">Inches</lable>
                                            <input type="number" min="0.00" class="form-control w-100 " style="padding: 11px !important; " id="inches" name="quest_16['inches']" placeholder="0.0">
                                    </div>
                                </div>
                                <div class="d-flex cm d-flex justify-content-end d-none">
                                    <div class="col-6">
                                        <label for="cm" class="form-lable px-2">cm</lable>
                                            <input type="number" min="0.00" class="form-control w-100 " style="padding: 11px !important; " id="cm" name="quest_16['cm']" placeholder="0.0">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group px-4 pt-4 pb-2">
                        <div class="question ">
                            <p class="me-auto">What is your weight?</p>
                            <div class="mt-2 mb-4">
                                <div class="col-9" style="cursor:pointer;">
                                    <p id="weight_switch" class="text-end btn-link fw-bold">Switch to Kg</p>
                                </div>
                                <div class="d-flex stone d-flex justify-content-end ">
                                    <div class="col-4">
                                        <label for="stone" class="form-lable ">Stone</lable>
                                            <input type="number" min="0.00" class="form-control w-100 " style="padding: 11px !important; " id="stone" name="quest_17['stone']" placeholder="0.0">
                                    </div>
                                    <div class="col-4">
                                        <label for="pounds" class="form-lable ">Pounds</lable>
                                            <input type="number" min="0.00" class="form-control w-100 " style="padding: 11px !important; " id="pounds" name="quest_17['pounds']" placeholder="0.0">
                                    </div>
                                </div>
                                <div class="d-flex kg d-flex justify-content-end d-none">
                                    <div class="col-6">
                                        <label for="kg" class="form-lable px-2">Kg</lable>
                                            <input type="number" min="0.00" class="form-control w-100 " style="padding: 11px !important; " id="kg" name="quest_17['kg']" placeholder="0.0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group question" style=" background: none; padding:none; margin:none;">
                        <div class="d-flex align-items-center m-3 mb-5  ">
                            <button id="continue_next" type="submit" class="btn btn-outline-success bnt-checkout fw-bold rounded-1" style="border:#ced4da 2xp solid; ">Proceed to Checkout</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- second div  -->
        <div class="col-md-4 bg-info mb-5 rounded-3" style="border-radius: 25px !important;">
            <div class="trackcompleted mb-4 ">
                <div class="text">
                    <h1>How it works</h1>
                    <hr class="my-3">
                </div>
                <div class="q1complete">
                    <div class="mt-4 d-flex gap-2">
                        <span style="width: 29px; height: 29px; background: #00c4a3; color: #fff; text-align: center; border-radius: 50%; ">&#49; </span> <span>Complete a consultation</span>
                    </div>

                    <p>You will need to begin by completing an ailment-based consultation. This will be a set of
                        questions related to your symptoms, medical history and any other information our
                        prescribers might need to be able to recommend a suitable treatment.</p>
                </div>
                <div class="q2complete">
                    <div class="mt-3 d-flex gap-2">
                        <span style="width: 29px; height: 29px; background: #00c4a3; color: #fff; text-align: center; border-radius: 50%; ">&#50; </span> <span>Browse treatments</span>
                    </div>

                    <p>Explore our wide range of medications, diagnostic tools and over the counter treatments
                        to learn more about how they work, what they are used for and how much they cost.</p>
                </div>
                <div class="q3complete">
                    <div class="mt-3 d-flex ">
                        <span style="width: 29px; height: 29px; background: #00c4a3; color: #fff; text-align: center; border-radius: 50%; ">&#51; </span> <span>Wait for a prescriber to review your request</span>
                    </div>

                    <p>You can either wait on our website or you can leave the page and wait for a notification
                        from us to let you know that a prescriber has finished reviewing your consultation.</p>
                </div>
                <div class="q4complete">
                    <div class="mt-3 d-flex gap-2">
                        <span style="width: 29px; height: 29px; background: #00c4a3; color: #fff; text-align: center; border-radius: 50%; ">&#52; </span> <span>Purchase treatment</span>
                    </div>
                    <p>From our selection of available prescription-only and over-the-counter products, the
                        prescriber will let you know which ones they have approved for your condition. From
                        here, you can select your chosen option and continue to payment to complete your order.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="depended_questions" class="depended_q d-none">

    <div id="question_{{$questions[1]['id']}}" class="question px-1" style="display:none;">
        <hr class="my-3">
        <div class="mb-0">
            <label for="quest_{{$questions[1]['id']}}" class="form-label pr-2">{{$questions[1]['title'] ?? '' }}</label>
            <textarea class="form-control" id="quest_{{$questions[1]['id']}}" name="quest_{{$questions[1]['id']}}" rows="7" style="height: 135px; border-radius:15px; " placeholder="Please provide any additional details here" required=''></textarea>
        </div>
    </div>

    <div id="question_{{$questions[2]['id']}}" class="question px-1" style="display:none;">
        <hr class="my-3">
        <div class="d-flex question align-items-start">
            <p class="me-auto mb-2 pt-1" style="font-weight: 400;">{{$questions[2]['title'] ?? '' }}</p>
            <label class="btn" style="padding: 0;">
                <input type="radio" name="quest_{{$questions[2]['id']}}" class="btn-radio option" value="Yes" data-append_id="apped_quest_{{$questions[2]['id']}}" data-selector="question_{{$questions[3]['id']}}" data-label="Yes" required>
            </label>
            <label class="btn" style="padding: 0;">
                <input type="radio" name="quest_{{$questions[2]['id']}}" class="btn-radio option" value="No" data-append_id="apped_quest_{{$questions[2]['id']}}" data-selector="alert_0" data-label="No" required>
            </label>
        </div>
        <div id="apped_quest_{{$questions[2]['id']}}">
        </div>
    </div>

    <div id="question_{{$questions[3]['id']}}" class="question px-1" style="display:none;">
        <hr class="my-3">
        <div class="mb-0">
            <div class="form-group">
                <label for="quest_{{$questions[3]['id']}}" class="form-label pr-2">{{$questions[3]['title'] ?? '' }}</label>
                <input type="text" class="form-control" id="quest_{{$questions[3]['id']}}" name="quest_{{$questions[3]['id']}}" list="list-timezone" placeholder="Please provide gp-location" required=''>
                <datalist id="list-timezone" class="dropdown-menu dropdown-menu-left">>
                    @foreach($gp_locations as $key => $value)
                    <option>
                        <div><strong>{{$value['b']}}</strong>,{{$value['e'] }}<br />{{$value['f'] }},{{$value['i']}}</div>
                    </option>
                    @endforeach
                </datalist>
            </div>
        </div>
    </div>
</div>
<div id="alert_0" class="question px-1" style="display:none;">
    <hr class="my-2">
    <div class="mb-0">
        <div class="alert alert-danger bg-danger ">
            <p class="px-2 fw-semibold text-white">We might need to inform Your GP depending on the product you have purchased. You can change your answer to 'Yes' and continue.</p>
        </div>
    </div>
</div>

<div id="alert_1" class="question px-1" style="display:none;">
    <hr class="my-2">
    <div class="mb-0">
        <div class="alert alert-danger bg-danger ">
            <p class="px-2 fw-semibold text-white">Unfortunately, we cannot recommend a suitable treatment for you. If you did this in error, you have the choice to change your answer. If you have any questions about this consultation, please email info@online-pharmacy4u.co.uk.</p>
        </div>
    </div>
</div>

<div id="question_{{$questions[6]['id']}}" class="question px-1" style="display:none;">
    <hr class="my-3">
    <div class="mb-0">
        <label for="quest_{{$questions[6]['id']}}" class="form-label pr-2">{{$questions[6]['title'] ?? '' }}</label>
        <textarea class="form-control" id="quest_{{$questions[6]['id']}}" name="quest_{{$questions[6]['id']}}" rows="7" style="height: 135px; border-radius:15px; " placeholder="Please provide any additional details here" required=''></textarea>
    </div>
</div>

<div id="question_{{$questions[8]['id']}}" class="question px-1" style="display:none;">
    <hr class="my-3">
    <div class="mb-0">
        <label for="quest_{{$questions[8]['id']}}" class="form-label pr-2">{{$questions[8]['title'] ?? '' }}</label>
        <textarea class="form-control" id="quest_{{$questions[8]['id']}}" name="quest_{{$questions[8]['id']}}" rows="7" style="height: 135px; border-radius:15px; " placeholder="Please provide any additional details here" required=''></textarea>
    </div>
</div>

<div id="question_{{$questions[10]['id']}}" class="question px-1" style="display:none;">
    <hr class="my-3">
    <div class="mb-0">
        <div class="alert alert-warning bg-warning alert-dismissible">
            <button type="button" class=" text-dark btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <p class="px-2 fw-semibold text-white">Please ensure you have included the strength and the dose of each medicine you have listed, e.g. Ramipril 5mg Tablets Once Daily. Failure to do so may cause delays with your order.</p>
        </div>
    </div>
    <hr class="my-3">
    <div class="mb-0">
        <label for="quest_{{$questions[10]['id']}}" class="form-label pr-2">{{$questions[10]['title'] ?? '' }}</label>
        <textarea class="form-control" id="quest_{{$questions[10]['id']}}" name="quest_{{$questions[10]['id']}}" rows="7" style="height: 135px; border-radius:15px; " placeholder="Please provide any additional details here" required=''></textarea>
    </div>
</div>

<div id="question_{{$questions[12]['id']}}" class="question px-1" style="display:none;">
    <hr class="my-3">
    <div class="mb-0">
        <label for="quest_{{$questions[12]['id']}}" class="form-label pr-2">{{$questions[12]['title'] ?? '' }}</label>
        <textarea class="form-control" id="quest_{{$questions[12]['id']}}" name="quest_{{$questions[12]['id']}}" rows="7" style="height: 135px; border-radius:15px; " placeholder="Please provide any additional details here" required=''></textarea>
    </div>
</div>

<div id="question_{{$questions[14]['id']}}" class="question px-1" style="display:none;">
    <hr class="my-3">
    <div class="mb-0">
        <label for="quest_{{$questions[14]['id']}}" class="form-label pr-2">{{$questions[14]['title'] ?? '' }}</label>
        <textarea class="form-control" id="quest_{{$questions[14]['id']}}" name="quest_{{$questions[14]['id']}}" rows="7" style="height: 135px; border-radius:15px; " placeholder="Please describe here ..." required=''></textarea>
    </div>
</div>

</div>
<!-- modal not continue -->
<div class="modal fade" id="attention_modal" tabindex="-1">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger py-2 px-2">
                <h5 class="modal-title mx-5 my-3 text-white fw-bold "> Attention !</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <p class="text-danger fw-bold">You can't proceed further.</p>
                        <p class="text-success fw-bold">Please review your selections.</p>
                        <p>You are unable to continue if you do not agree to the terms and conditions of our site.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@pushOnce('scripts')
<script>
    $(document).ready(function() {
        $(document).on('click', '.option', function() {
            var selector = $(this).data('selector');
            var append_id = $(this).data('append_id');
            var html = '';

            if (selector == 'nothing') {
                $('#' + append_id).html('');
            } else {
                var html = $('#' + selector).clone().removeAttr('style').html();
                $('#' + append_id).html(html).slideDown('medium', function() {
                    $(this).find('textarea').val('');
                });
            }
        });

        $('#premed_generic_question').submit(function() {
            if ($('#premed_generic_question .alert-danger').length > 0) {
                $('#attention_modal').modal("show");
                // $('#continue_next').attr('disabled',true);
                return false;
            }
            return true;
        });

        $('#height_switch').click(function() {
            $('.cm').toggleClass('d-none');
            $('.inch').toggleClass('d-none');
            var buttonText = $(this).text() === 'Switch to cm' ? 'Switch to ft, in' : 'Switch to cm';
            if (buttonText === 'Switch to ft, in') {
                $('#inches').attr('required', false).val('');
                $('#feet').attr('required', false).val('');
                $('#cm').attr('required', true).val('');
            } else {
                $('#feet').attr('required', true).val('');
                $('#inches').attr('required', true).val('');
                $('#cm').attr('required', false).val('');
            }
            $(this).text(buttonText);
        });

        $('#weight_switch').click(function() {
            $('.stone').toggleClass('d-none');
            $('.kg').toggleClass('d-none');
            var buttonText = $(this).text() === 'Switch to Kg' ? 'Switch to st, lb' : 'Switch to Kg';
            if (buttonText === 'Switch to st, lb') {
                $('#stone').attr('required', false).val('');
                $('#pounds').attr('required', false).val('');
                $('#kg').attr('required', true).val('');
            } else {
                $('#stone').attr('required', true).val('');
                $('#pounds').attr('required', true).val('');
                $('#kg').attr('required', false).val('');
            }
            $(this).text(buttonText);
        });

    });
</script>

<!-- Select2 -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $("#single").select2({
        placeholder: "Select a programming language",
        allowClear: true
    });
</script> -->
@endPushOnce