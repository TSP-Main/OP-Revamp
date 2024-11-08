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
        padding: 7px 20px !important;
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
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="firstconsultationstart">
                <div class="text">
                    <h2>General Health Questions</h2>
                    <p>The information you provide us is treated with the utmost confidentiality and will be
                        reviewed by a GPhC
                        registered independent prescriber. The questions listed are to provide the prescriber
                        with
                        an appropriate
                        level of information to make an informed decision on whether the treatment is suitable
                        or
                        not.</p>
                </div>
                <form id="pmed_generic_question" action="{{route('web.consultationStore')}}" method="post">
                    @csrf
                    <input type="hidden" name="template" required value="{{$template}}">
                    <input type="hidden" name="product_id" required value="{{$product_id}}">
                    <div class="form-group Indpendent_q px-4" id="question_0">
                        <div class="d-flex align-items-center">
                            <p class="m-0 fw-bold">{{$questions[0]['title'] ?? '' }}</p>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input styled-radio" type="radio" name="quest_1" id="quest_1_option1" value="Me" required>
                            <label class="form-check-label" for="quest_1_option1">Me</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input styled-radio" type="radio" name="quest_1" id="quest_1_option2" value="Myself & someone else" required>
                            <label class="form-check-label" for="quest_1_option2">Myself & someone else</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input styled-radio" type="radio" name="quest_1" id="quest_1_option3" value="Someone else" required>
                            <label class="form-check-label" for="quest_1_option3">Someone else </label>
                        </div>
                    </div>

                    <div class="form-group Indpendent_q px-4" id="question_1" style="display:none;">
                        <div class="d-flex align-items-center">
                            <p class="m-0 fw-bold">{{$questions[1]['title'] ?? '' }}?</p>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input styled-radio" type="radio" name="quest_2" id="quest_2_quest_2_option1" value="Male" required>
                            <label class="form-check-label" for="quest_2_option1">Male</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input styled-radio" type="radio" name="quest_2" id="quest_2_option2" value="Female" required>
                            <label class="form-check-label" for="quest_2_option2">Female</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input styled-radio" type="radio" name="quest_2" id="quest_2_option3" value="Male & Female" required>
                            <label class="form-check-label" for="quest_2_option3">Male & Female</label>
                        </div>
                    </div>

                    <div class="form-group Indpendent_q px-4" id="question_2" style="display:none;">
                        <div class="d-flex align-items-center">
                            <p class="m-0 fw-bold">{{$questions[2]['title'] ?? '' }}</p>
                        </div>
                        <div class="mt-3 mb-0">
                            <label for="quest_3" class="form-label">Additional Details:</label>
                            <textarea class="form-control" name="quest_3" id="quest_3" rows="7" style="height: 135px; border-radius:15px; " placeholder="medicine be used for write here" required=''></textarea>
                        </div>
                    </div>


                    <div class="form-group Indpendent_q px-4" id="question_3" style="display:none;">
                        <div class="d-flex align-items-center">
                            <p class="m-0 fw-bold">{{$questions[3]['title'] ?? '' }}</p>
                        </div>
                        <div class="mt-3 mb-0">
                            <label for="quest_4" class="form-label">Additional Details:</label>
                            <textarea class="form-control" name="quest_4" id="quest_4" rows="7" style="height: 135px; border-radius:15px; " placeholder="Please provide any additional details here" required=''></textarea>
                        </div>
                    </div>

                    <div class="form-group Indpendent_q px-4" id="question_4" style="display:none;">
                        <div class="d-flex align-items-center">
                            <p class="m-0 fw-bold">{{$questions[4]['title'] ?? '' }}</p>
                        </div>
                        <div class="mt-3 mb-0">
                            <label for="quest_6" class="form-label">Additional Details:</label>
                            <textarea class="form-control" name="quest_5" id="quest_5" rows="7" style="height: 135px; border-radius:15px; " placeholder="Please provide any additional details here" required=''></textarea>
                        </div>
                    </div>

                    <div class="form-group Indpendent_q px-3" id="question_5" style="display:none;">
                        <div class="d-flex align-items-start">
                            <p class="me-auto " style="font-weight: 400;">{{$questions[5]['title'] ?? '' }}</p>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_6" class="btn-radio" value="Yes" data-label="Yes" required>
                            </label>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_6" class="btn-radio" value="No" data-label="No" required>
                            </label>
                        </div>
                    </div>

                    <div class="form-group dpendent_q px-4 " id="dp_question_1" style="display:none;">
                        <div class="mt-3 mb-0 ">
                            <label for="dp_quest_1" class="form-label">{{$questions[6]['title'] ?? '' }}</label>
                            <textarea class="form-control" id="dp_quest_1" name="quest_7" rows="7" style="height: 135px; border-radius:15px; " placeholder="Please provide any additional details here" required=''></textarea>
                        </div>
                    </div>

                    <div class="form-group Indpendent_q px-3" id="question_6" style="display:none;">
                        <div class="d-flex align-items-start">
                            <p class="me-auto " style="font-weight: 400;">{{$questions[7]['title'] ?? '' }}</p>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_8" class="btn-radio" value="Yes" data-label="Yes" required>
                            </label>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_8" class="btn-radio" value="No" data-label="No" required>
                            </label>
                        </div>
                    </div>

                    <div class="form-group dpendent_q px-4 " id="dp_question_2" style="display:none;">
                        <div class="mt-3 mb-0 ">
                            <label for="dp_quest_2" class="form-label">{{$questions[8]['title'] ?? '' }}</label>
                            <textarea class="form-control" id="dp_quest_2" name="quest_9" rows="7" style="height: 135px; border-radius:15px; " placeholder="Please provide any additional details here" required=''></textarea>
                        </div>
                    </div>

                    <div class="form-group Indpendent_q px-3" id="question_7" style="display:none;">
                        <div class="d-flex align-items-start">
                            <p class="me-auto " style="font-weight: 400;">{{$questions[9]['title'] ?? '' }}</p>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_10" class="btn-radio " value="Yes" data-label="Yes" required>
                            </label>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_10" class="btn-radio " value="No" data-label="No" required>
                            </label>
                        </div>
                    </div>

                    <div class="form-group dpendent_q px-4 " id="dp_question_3" style="display:none;">
                        <div class="d-flex align-items-center">
                            <p class="m-0 fw-bold">{{$questions[10]['title'] ?? '' }}</p>
                        </div>
                        <div class="mt-3 mb-0 ">
                            <label for="dp_quest_3" class="form-label">Additional Details:</label>
                            <textarea class="form-control" id="dp_quest_3" name="quest_11" rows="7" style="height: 135px; border-radius:15px; " placeholder="Please provide any additional details here" required=''></textarea>
                        </div>
                    </div>

                    <div class="form-group Indpendent_q px-3" id="question_14" style="display:none;">
                        <div class="d-flex align-items-start">
                            <p class="me-auto " style="font-weight: 400;">You agree that you have not placed multiple orders recently of this item.</p>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_14" class="btn-radio" value="Yes" data-label="Yes" required>
                            </label>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_14" class="btn-radio" value="No" data-label="No" required>
                            </label>
                        </div>
                    </div>

                    <div id="alert_2" class="px-1" style="display:none;">
                        <hr style="height:2px;" class="mb-2 mt-0 bg-dark">
                        <div class="mb-0">
                            <div class="alert py-4  bg-warning ">
                                <p class="px-2  fw-semibold text-white">Please note that you will be charged a £2.00 admin fee and this order will be rejected</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group Indpendent_q px-3" style="margin-bottom: 15px; display:none;">
                        <div class="d-flex align-items-start">
                            <p class="me-auto " style="font-weight: 400;">{{$questions[11]['title'] ?? '' }}</p>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_12" class="btn-radio" value="Yes" data-label="Yes" required>
                            </label>
                            <label class="btn" style="padding: 0;">
                                <input type="radio" name="quest_12" class="btn-radio" value="No" data-label="No" required>
                            </label>
                        </div>
                    </div>

                    <div id="alert_1" class="px-1" style="display:none;">
                        <hr style="height:2px;" class="mb-2 mt-0 bg-dark">
                        <div class="mb-0">
                            <div class="alert py-4  bg-danger ">
                                <p class="px-2  fw-semibold text-white">You are unable to continue if you do not agree to the terms and conditions of our site.</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group Indpendent_q px-3" style="display:none;">
                        <div class="d-flex align-items-start">
                            <div>
                                <lable for="quest_13" class="me-auto " style="font-weight: 400;">{!! $questions[12]['title'] ?? '' !!}</lable>
                            </div>
                            <div>
                                <input class="custom-checkbox" id="quest_13" name="quest_13" type="checkbox" value="agreed" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group Indpendent_q" style="display:none; background: none; padding:none; margin:none;">
                        <div class="d-flex align-items-center m-3 mb-5  ">
                            <button type="submit" class="btn btn-outline-success bnt-checkout fw-bold rounded-1" style="border:#ced4da 2xp solid; ">Proceed to Checkout</button>
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

                    <p>You can either wa
                        it on our website or you can leave the page and wait for a notification
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
        var currentQuestion = 0;
        var totalQuestions = $('.Indpendent_q').length;

        $("input[name='quest_6']").change(function() {
            if ($(this).val() === 'Yes') {
                $("#dp_quest_1").attr("required", true);
                $("#dp_question_1").slideDown('fast');
            } else {
                $("#dp_question_1").slideUp('fast');
                $("#dp_quest_1").val("").removeAttr("required");
            }
        });

        $("input[name='quest_8']").change(function() {
            if ($(this).val() === 'Yes') {
                $("#dp_quest_2").attr("required", true);
                $("#dp_question_2").slideDown('fast');
            } else {
                $("#dp_question_2").slideUp('fast');
                $("#dp_quest_2").val("").removeAttr("required");
            }
        });


        $("input[name='quest_10']").change(function() {
            if ($(this).val() === 'Yes') {
                $("#dp_quest_3").attr("required", true);
                $("#dp_question_3").slideDown('fast');
            } else {
                $("#dp_question_3").slideUp('fast');
                $("#dp_quest_3").val("").removeAttr("required");
            }
        });

        $("input[name='quest_12']").change(function() {
            if ($(this).val() === 'No') {
                $(".alert").addClass('alert-danger');
                $("#alert_1").show().slideDown('fast');
            } else {
                $(".alert").removeClass('alert-danger');
                $("#alert_1").hide().slideUp('fast');
            }
        });

        $("input[name='quest_14']").change(function() {
            if ($(this).val() === 'No') {
                $(".alert").addClass('alert-danger');
                $("#alert_2").show().slideDown('fast');
            } else {
                $(".alert").removeClass('alert-danger');
                $("#alert_2").hide().slideUp('fast');
            }
        });

        $('input[type="radio"], input[type="checkbox"]').change(function() {
            showNextQuestion();
        });

        var textareaFocusCount = 0;
        $('textarea').on('input', function() {
            textareaFocusCount++;
            if (textareaFocusCount >= 2) {
                showNextQuestion();
            }
        });

        function showNextQuestion() {
            if (currentQuestion < totalQuestions - 1) {
                if (validateInput(currentQuestion)) {
                    let next_quest = ++currentQuestion;
                    $('.Indpendent_q').eq(next_quest).slideDown('fast');
                }
            }
        }

        function validateInput(questionIndex) {
            var valid = true;
            var radioGroups = {};

            $('.Indpendent_q').eq(questionIndex).find('input[type="radio"], input[type="checkbox"]').each(function() {
                if ($(this).is(':radio')) {
                    var groupName = $(this).attr('name');
                    if (!radioGroups[groupName]) {
                        radioGroups[groupName] = false;
                    }
                    if ($(this).is(':checked')) {
                        radioGroups[groupName] = true;
                    }
                } else if ($(this).is(':checkbox') && !$(this).is(':checked')) {
                    valid = false;
                    return false;
                }
            });

            $.each(radioGroups, function(key, value) {
                if (!value) {
                    valid = false;
                    return false;
                }
            });

            $('.Indpendent_q').eq(questionIndex).find('textarea').each(function() {
                if ($(this).val().trim() === '') {
                    valid = false;
                    return false;
                }
            });

            return valid;
        }

        $('#pmed_generic_question').submit(function() {
            if ($('.alert-danger').length > 0) {
                $('#attention_modal').modal("show");
                return false;
            }
            return true;
        });
    });
</script>

@endPushOnce